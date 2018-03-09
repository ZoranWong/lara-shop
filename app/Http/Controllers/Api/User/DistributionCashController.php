<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\Controller;
use App\Models\Distribution\ApplySetting;
use App\Models\Distribution\CommissionCashApply;
use App\Models\Distribution\CommissionCashDetail;
use App\Models\Distribution\CommissionCashSettings;
use App\Models\Distribution\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Distribution\Order as DistributionOrder;

class DistributionCashController extends Controller
{
    /**
     * 提现申请
     * money   int  申请金额
     * return    string
     * status    true 申请成功  false  申请失败
     * remaining  int  剩余提现额度
     * @param Request $request
     * @return \Response
     * @throws
     **/
    public function extract(Request $request)
    {
        try {
            $queryParams = $request -> all();
            $money = array_get($queryParams,'money');
            if(intval($money <= 0) || !preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $money)) {
                throw new \Exception('金额输入错误!');
            }

            if ($money < 1) {
                throw new \Exception('提现金额不能低于1元!');
            }
            if(!$this->user){
                return \Response::errorApi('获取不到用户信息');
            }
            if(!$queryParams['store_id']){
                return \Response::errorApi('获取不到商家信息');
            }
            $storeId = $queryParams['store_id'];
            $userId = $this->user->id;
            /*获取用户信息  判断用户身份*/
            $member = Member::where('user_id', $userId)
                ->where('store_id', $storeId)
                ->first();
            if (!$member) {
                throw new \Exception('你不是分销商!');
            }
            /*获取店铺提现设置*/
            $setting = CommissionCashSettings::where('store_id', $storeId)
                ->first();
            /*商户未设置则默认最低1元最高20000元*/
            if(!$setting) {
                /*最小提现额度*/
                $setting['min_cash_num'] = 1;
                /*最大提现额度*/
                $setting['max_cash_num'] = 20000;
            } else{
                if (!isset($setting['min_cash_num']) || $setting['min_cash_num'] == null) {
                    $setting['min_cash_num'] = 1;
                } elseif (!isset($setting['max_cash_num']) || $setting['max_cash_num'] == null) {
                    $setting['max_cash_num'] = 20000;
                }
            }

            if($money > $member['amount'] || $money < $setting['min_cash_num'] || $money > $setting['max_cash_num']) {
                throw new \Exception('申请提现佣金小于最低提现额度或大于可提现额度,请重新填写!');
            }
            $date = date('Y-m-d H:i:s', time());
            $fullName=$member['full_name'];
            $result = new CommissionCashApply();
            $result->store_id = $storeId;
            $result->distribution_member_id = $member->id;
            $result->distribution_user_id = $userId;
            $result->mobile = $member->user->mobile;
            $result->name = "$fullName";
            $result->apply_time = $date;
            $result->amount = $money;
            $result->wait_amount = $money;
            $result->status = 0;
            $result->save();

            if (!$result) {
                throw new \Exception('申请失败,未能提交数据!');
            }

            $remaining['amount'] = $member->amount - $money;
            /*更新分销商Member表 可提现佣金*/
            $upMember = Member::where('user_id', $userId)
                ->update($remaining);

            /*默认失败状态*/
            $data['status'] = false;
            if ($upMember) {
                $data['status'] = true;
                /*剩余可提现额度*/
                $data['remaining'] = number_format($remaining['amount'] ,2);
                //  订单拆分 单笔大于200元时 拆分多个订单
                dispatch((new \App\Jobs\Distribution\CashCommissionDecomposition($result->id)));
            }
            return \Response::ajax($data);
        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }


    /**
     * 提现记录
     * return
     * 数据总计         $total
     * 成功提现金额     $totalAmount
     * 提现渠道 0微信,1支付宝      type
     * 时间             $apply_time
     * 金额             $amount
     * 状态             $status(0待处理 1已打款 2已取消)
     * @param Request $request
     * @return  \Response
     * @throws
     **/
    public function extractHistory(Request $request)
    {
        try {
            if(!$this->user){
                return \Response::errorApi('获取不到用户信息');
            }
            if(!$request->input('store_id', null)){
                return \Response::errorApi('获取不到商家信息');
            }
            $queryParams = $request->all();
            $perpage = 10;
            $page = array_get($queryParams, 'page', 1);
            $page = intval($page) >= 1 ? intval($page) : 1;
            $offset = ($page - 1) * $perpage;
            $storeId = $queryParams['store_id'];
            $userId = $this->user->id;
            /*用户身份验证*/
            $isUser = Member::where('user_id', $userId)
                ->count();
            if ($isUser == 0) {
                throw new \Exception('您不是分销商!');
            }
            $user = [];
            $user['user_id'] = $userId;
            $user['store_id'] = $storeId;
            /*数据总计*/
            $info['total'] = CommissionCashApply::where($user)->count();
            /*成功提现额度*/
            $info['totalAmount'] = CommissionCashApply::where($user)
                ->where('status', CommissionCashApply::PAY_SUCCESS)
                ->sum('amount');
            $info['totalAmount'] = number_format($info['totalAmount'], 2);
            /*订单列表*/
            $info['data'] = CommissionCashApply::where($user)
                ->orderBy('apply_time', 'DESC')
                ->offset($offset)
                ->limit($perpage)
                ->get();

            foreach($info['data'] as $v)
            {
                $v['amount'] = number_format($v['amount'], 2);
                $v['wait_amount'] = number_format($v['wait_amount'], 2);
                /*前端展示:1为已打款 0待处理,数据库字段:0待审核 1待打款 2已打款 3打款中*/
                $v['status'] = $v['status'] === CommissionCashApply::PAY_SUCCESS ?
                    CommissionCashApply::FRONT_SHOW_SUCCESS : CommissionCashApply::FRONT_SHOW_WAIT;
            }
            return \Response::ajax($info);
        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }

    /**
     * 佣金 详情 分销商
     * return
     * 订单数量     total
     * 累计佣金     sum_commission
     * 订单号       order_number
     * 时间日期     order_created_at
     * 佣金金额     commission
     * 佣金状态     status
     * @param Request $request
     * @return \Response
     * @throws
     */
    public function detailListMe(Request $request)
    {
        try {
            $queryParams = $request->all();
            $perpage = 10;
            $page = array_get($queryParams,'page',1);
            $page = intval($page) >= 1 ? intval($page) : 1;
            $offset = ($page - 1) * $perpage;
            if(!$this->user){
                return \Response::errorApi('获取不到用户信息');
            }
            if(!$request->input('store_id', null)){
                return \Response::errorApi('获取不到商家信息');
            }
            $storeId = $queryParams['store_id'];
            $userId = $this->user->id;
            /*获取用户信息  判断用户身份*/
            $userInfo = Member::where('user_id', $userId)
                ->where('store_id', $storeId)
                ->first();
            if (!$userInfo) {
                throw new \Exception('你不是分销商!');
            }

            $orderModel = DistributionOrder::where('store_id', $storeId)
                ->where(function (Builder $query) use ($userId) {
                    $query->orWhere('buyer_user_id', $userId)
                        ->orWhere('father_id', $userId)
                        ->orWhere('grand_father_id', $userId)
                        ->orWhere('great_grand_father_id', $userId);
                });

            $orderInfo = $orderModel->orderBy('id', 'DESC')
                ->get()->map(function (DistributionOrder $item) use ($userId) {
                if ($item->buyer_user_id === $userId) {
                    /*自购佣金 不做任何操作 直接输出 commission字段*/
                } elseif ($item->father_id === $userId) {
                    $item->commission = $item->father_commission;
                    $item->commission_status = $item->father_commission_status;
                } elseif ($item->grand_father_id == $userId) {
                    $item->commission = $item->grand_father_commission;
                    $item->commission_status = $item->grand_father_commission_status;
                } else {
                    $item->commission = $item->great_grand_father_commission;
                    $item->commission_status = $item->great_grand_commission_status;
                }
                /*佣金金额*/
                $item->commission = number_format($item->commission, 2);
                /*订单时间*/
                $item->total_commission = $item->total_commission == 0 ? 0 : number_format($item->total_commission, 2);
                $item->refund_fee = $item->refund_fee == 0 ? 0 : number_format($item->refund_fee, 2);
                $item->payment_fee = $item->payment_fee == 0 ? 0 : number_format($item->payment_fee, 2);
                if ($item->commission_status == 0) {
                    return $item;
                }else{
                    return null;
                }
            })->toArray();
            //  订单列表
            $orderList = [];
            $orderInfo = array_filter($orderInfo);
            $user['total'] = count($orderInfo);
            if (count($orderInfo) > 0) {
                //  获取 其中需要展示的数据
                $orderList = array_slice($orderInfo,$offset,$perpage);
            }
            $memberData = Member::select(['total_wait_commission_amount', 'total_wait_commission_amount'])
                ->where('user_id', $userId)
                ->first();
            $commission = $memberData ? ($memberData->total_paid_commission_amount) + ($memberData->total_wait_commission_amount) : 0;
            /*订单佣金(包括已结算和未结算的佣金)*/
            $user['sum_commission'] = number_format($commission, 2);
            $user['data'] = $orderList;
            return \Response::ajax($user);
        }catch(\Exception $e){
            return \Response::errorAjax($e->getMessage());
        }
    }

    /**
     * 佣金统计
     * return
     * amount                账户余额(可提金币)
     * total_cash_amount     已打款
     * total_commission_amount 分销订单金额总计(已结算)
     * total_commission_wait   未结算
     * @param Request $request
     * @return \Response
     * @throws
     **/
    public function detail(Request $request)
    {
        try {
            if(!$this->user){
                return \Response::errorApi('获取不到用户信息');
            }
            if(!$request->input('store_id', null)){
                return \Response::errorApi('获取不到商家信息');
            }
            $storeId = $request->input('store_id');
            $userId = $this->user->id;
            $user['user_id'] = $userId;
            $user['store_id'] = $storeId;

            $info = Member::select(['amount', 'total_paid_commission_amount',' total_wait_commission_amount', 'total_cash_amount'])
                ->where($user)
                ->first();
            if (!$info) {
                throw new \Exception('您不是分销商!');
            }
            /*可提现额度*/
            $info['amount'] = number_format($info['amount'], 2);
            /*待结算*/
            $info['total_wait_commission_amount'] = number_format($info['total_wait_commission_amount'], 2);
            /*分销订单金额总计*/
            $info['total_commission_amount'] = number_format(($info['total_paid_commission_amount'] + $info['total_wait_commission_amount']),2);
            $info['total_cash_amount'] = number_format($info['total_cash_amount'], 2);
            return \Response::ajax($info);

        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }

    /**
     * 佣金 提现设置  查询当前设置参数 没有设置返回最低提现1元 最高2000元
     * @param Request $request
     * @return \Response
     * min_cash_num  最低提现金额
     * max_cash_num   最高提现金额 //当前需求 最高提现不封顶 保留字段应对日后改需求
     * commission_days  结算天数
     * @throws
     * */
    public function extractSettingShow(Request $request)
    {
        try{
            if(!$request->input('store_id', null)){
                return \Response::errorApi('获取不到商家信息');
            }
            $storeId = $request->get('store_id');
            $setting = ApplySetting::with('cashSetting')
                ->where('store_id', $storeId)
                ->first();
            if ($setting) {
                /*佣金结算天数*/
                $cash['commission_days'] = $setting->commission_days;
                if ($setting['cashSetting'] !== "") {
                    /*最小提现额度*/
                    $cash['min_cash_num'] = number_format($setting['cashSetting']['min_cash_num'], 2);
                    /*最大提现额度*/
                    $cash['max_cash_num'] = number_format($setting['cashSetting']['max_cash_num'], 2);
                } else {
                    $cash['min_cash_num'] = 1;
                    $cash['max_cash_num'] = 20000;
                }
            } else {
                throw new \Exception('请先填写佣金设置!');
            }
            unset($setting);

            $cash['store_id'] = $storeId;
            return \Response::ajax($cash);
        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }
}