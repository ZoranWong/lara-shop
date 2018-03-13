<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\Controller;
use App\Models\Distribution\ApplySetting;
use App\Models\Distribution\Member;
use App\Models\Distribution\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

class DistributionController extends Controller
{

    /**
     * 分销商申请
     * @param Request $request
     * @return \Response
     * @throws
     **/
    public function apply(Request $request)
    {
        try {
            $input['store_id']  = $request->input('store_id', null);
            if($input['store_id'] && $this->user){
                $input['user_id']  = $this->user->id;
                $basicSetting = ApplySetting::where('store_id', $input['store_id'])
                    ->first();
                $requiredParams = [];
                if($basicSetting &&  $basicSetting->info_status == 1) {
                    $requiredParams = [
                        'full_name'   => 'required|max:50',
                        'mobile'      => 'required|mobile',
                        'wechat'      => 'required|alpha_num'
                    ];
                    if($basicSetting->mobile_status) {
                        $requiredParams['code'] = 'required|max:10';
                    }
                }
                $input = array_merge($input, $this->validate($request, $requiredParams));

                $member = Member::where('user_id', $input['user_id'])->first();
                if($member && $member->apply_status != Member::STATUS_NOT_APPLY) {
                    throw new \Exception('您已经申请过分销商');
                }
                if(empty($member->path)) {
                    $member = new Member;
                    $member->user_id = $input['user_id'];
                    $member->store_id = $input['store_id'];
                    $member->depth = 1;
                    $member->father_id = 0;
                    $member->grand_father_id = 0;
                    $member->great_grand_father_id = 0;
                    $member->path = $input['user_id'];
                }
                if($requiredParams) {
                    $member->full_name   = $request->input('full_name');
                    $member->mobile      = $request->input('mobile');
                    $member->wechat      = $request->input('wechat');
                }
                $now = time();
                $member->apply_time   = $now;
                $member->apply_status = Member::STATUS_PASS;
                $member->join_time = $now;
                if($basicSetting &&  $basicSetting->check_way === ApplySetting::CHECK_MUST) {
                    $member->apply_status = Member::STATUS_WAIT_CHECK;
                    $member->join_time = 0;
                }
                $member->save();

                return \Response::ajax($member);
            }else{
                if(!$input['store_id']){
                    throw new \Exception('store_id参数错误！');
                }else{
                    throw new \Exception('未登录！');
                }
            }

        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }

    /**
     *分销首页
     * @param Request $request
     * @return \Response
     * @throws
     * head_image_url       会员头像
     * nickname         昵称
     * join_time        加入时间
     * total_order_amount        佣金总计(销售额)
     * total_commission_amount   累计结算佣金(累计已结算佣金)
     * amount           佣金余额(可提佣金)
     * level_name       分销商等级名称
     * order_num       订单数量(销售订单  按照当前店铺设置的分销层级 展示自购与下级订单)
     * team_num        下级人数(我的团队  按照当前店铺设置的分销层级 展示自购与下级人数)
     * alipay_account   提现申请的电话(返回上次提现申请时填写的支付宝账号,如果没有则为空)
     * */
    public function info(Request $request)
    {
        try {
            $storeId = $request->input('store_id', null);
            $user = $this->user;
            $userId = $user->id;
            $memberInfo = [];
            $data = Member::with('user')
                ->with(['level' => function(HasOne $query) use ($storeId)
                    {
                        $query->where('store_id', $storeId);
                    }])->where('store_id', $storeId)
                ->where('user_id', $userId)
                ->first();
            if(isset($data)) {
                //会员头像
                $memberInfo['head_image_url'] = $data->user->head_image_url;
                //会员昵称
                $memberInfo['nickname'] = $data->user->nickname;
                $memberInfo['join_time'] = $data->join_time  ? $data->join_time : "-";
                // 分销订单金额总计
                $memberInfo['amount'] = number_format($data->amount, 2);
                // 分销佣金总计
                $memberInfo['total_commission_amount'] = number_format(($data->total_wait_commission_amount + $data->total_paid_commission_amount), 2);
                // 分销商等级名称
                $memberInfo['level_name'] = isset($data->memberLevel) ? $data->memberLevel->name : "默认等级";
                //  获取店铺分销层级设置
                $fatherId = 'user_id';
                $grandFatherId = 'user_id';
                $greatGrandFatherId = 'user_id';
                $fansIdList = Member::where('store_id', $storeId)
                    ->where(function(Builder $item) use ($userId, $fatherId, $grandFatherId, $greatGrandFatherId) {
                        $item->orWhere($fatherId, $userId)
                            ->orWhere($grandFatherId, $userId)
                            ->orWhere($greatGrandFatherId, $userId);
                    })->pluck('user_id')
                    ->toArray();

                //销售额：自购及下级的佣金状态为已结算+未结算的订单的不含邮费的金额
                $userIdList = Member::where('store_id', $storeId)->where(function(Builder $query) use($userId){
                    $query->orWhere('user_id', $userId)
                        ->orWhere('father_id', $userId)
                        ->orWhere('grand_father_id', $userId)
                        ->orWhere('great_grand_father_id', $userId);
                })->pluck('user_id');

                $totalAmount = Order::whereIn('user_id', $userIdList)
                    ->whereIn('commission_settle_status', [Order::STATUS_UNSETTLED, Order::STATUS_SETTLED])
                    ->select([\DB::raw('SUM(payment_fee) as total_payment'), \DB::raw('SUM(refund_fee) as total_refund')])
                    ->first();

                $amount = 0;
                if ($totalAmount) {
                    $amount = ($totalAmount->total_payment - $totalAmount->total_refund) >= 0 ? ($totalAmount->total_payment - $totalAmount->total_refund) : 0;
                }
                // 分销订单金额总计
                $memberInfo['total_order_amount'] = $amount == null ? 0 : number_format($amount, 2);
                //统计分销团队人数 (不包括自己)
                $memberInfo['team_num'] = count($fansIdList) >= 1 ? count($fansIdList) - 1 : 0 ;
                //统计团队中订单数目 (包括自己的订单)
                $memberInfo['order_num'] = Order::whereIn('user_id', $fansIdList)->count();
            }
            unset($data);
            return \Response::ajax($memberInfo);
        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }

    // 分销商下级 ,我的团队
    /**
     * @param Request $request
     * @return \Response
     * @throws
     * */
    public function subordinate(Request $request)
    {
        try {
            $storeId = $request->input('store_id', null);
            $userId = $this->user->id;
            // 获取传递的参数
            $queryParams =  $request->all();
            $page = array_get($queryParams,'page',1);
            $level = array_get($queryParams,'level',1); //传入的分销商级别
            $validFields = [
                '1' => 'father_id',
                '2' => 'grand_father_id',
                '3' => 'great_grand_father_id'
            ];

            if(!in_array($level, array_keys($validFields))) {
                throw new \Exception('传入的数据不合法');
            }
            $limit = 10;
            $offset = ($page-1) * $limit;
            $data['list'] = Member::with('user')
                ->where('store_id', $storeId)
                ->where($validFields[$level], $userId)
                ->offset($offset)
                ->orderBy('join_time','desc')
                ->limit($limit)
                ->get()
                ->map(function( Member $item ) {
                    $userId = $item->user->id;
                    $order = Order::select(\DB::raw('count(*) as order_count, sum(payment_fee) as total_payment_fee'))
                        ->where(function (Builder $query) use($userId) {
                        $query->orWhere('user_id', $userId);
                            $query->orWhere('father_id', $userId);
                            $query->orWhere('grand_father_id', $userId);
                            $query->orWhere('great_grand_father_id', $userId);
                    })->where('commission_settle_status', Order::STATUS_SETTLED)->first();
                    // 账户佣金余额
                    $item->amount = number_format($item->amount, 2);
                    // 订单数量（佣金状态已结算）
                    $item->order_quantity = 0;
                    // 佣金状态已结算的订单金额
                    $item->total_payment_fee = 0;

                    if($order){
                        $item->order_quantity = $order->order_count;
                        $item->total_payment_fee = number_format($order->total_payment_fee, 2);
                    }
                    // 分销订单金额总计
                    $item->total_order_amount = number_format($item->total_order_amount, 2);
                    // 分销佣金总计
                    $item->total_commission_amount = number_format(($item->total_paid_commission_amount + $item->total_wait_commission_amount), 2);
                    // 已提现佣金
                    $item->total_cash_amount = number_format($item->total_cash_amount, 2);

                    $item->head_image_url = $item->user->head_image_url;

                    $item->nickname = $item->user->nickname;

                    unset($item->user);
                    return $item;
                });
            return \Response::ajax($data);
        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }

    /**
     * 分销商等级下线人数
     * @param Request $request
     * @return \Response [分销商的等级，各等级人数]
     * @throws
     */
    public function subordinateSetting(Request $request)
    {
        try {
            $userId = $this->user->id;
            $storeId = $request->input('store_id', null);
            $memberNum[0] = Member::where('store_id', $storeId)->where('father_id', $userId)->count();
            $memberNum[1] = Member::where('store_id', $storeId)->where('grand_father_id', $userId)->count();
            $memberNum[2] = Member::where('store_id', $storeId)->where('great_grand_father_id', $userId)->count();
            return \Response::ajax($memberNum);
        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }
}