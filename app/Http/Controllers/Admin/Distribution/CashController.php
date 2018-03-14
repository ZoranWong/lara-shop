<?php
/**
 * Created by PhpStorm.
 * User: Creya
 * Date: 2017/8/24
 * Time: 09:40
 */
namespace App\Http\Controllers\Admin\Distribution;

use App\Models\Distribution\CommissionCashApply;
use App\Models\Distribution\CommissionCashSettings;
use App\Models\Distribution\Member;
use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use App\Services\StoreService;
use DB;
use Excel;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class CashController extends Controller
{
    /**
     * @var Store
     * */
    protected $store = null;

    public function __construct()
    {
        $this->store = StoreService::getCurrentStore();
    }

    public function setting(Request $request)
    {
        if($request->method() === Request::METHOD_GET){
            $input = $this->validate($request,['store_id' => 'required|integer']);
            $result = CommissionCashSettings::whereStoreId($input['store_id'])->first();
            return \Response::ajax($result);
        }else if($request->method() === Request::METHOD_POST){
           $input =  $this->validate($request, [
               'store_id' => 'required|integer',
               'min_cash_num' => 'required|numeric'
            ]);

           $apply = CommissionCashSettings::firstOrNew(['store_id' => $input['store_id']]);
           if($apply){
               $apply->fill($input);
               $apply->save();
           }

           return \Response::ajax($apply);
        }

        return \Response::errorAjax('请求方法错误');
    }

    /*
     * id 订单号
     * nickname昵称/头像
     * head_image_url
     * name 姓名
     * mobile 手机
     * amount 金额
     * apply_time 提现时间
     * verify_time 审核时间
     *
    */
    public function cashList(Request $request)
    {
        $queryParams = $request->all();
        $status = array_get($queryParams, 'status');
        $nickname = null;
        $mobile = null;
        $name = null;
        $cashId = null;
        $time_start = null;
        $time_end = null;
        if ($status == 0) {
            $time_start = array_get($queryParams, 'audit_start_apply_time');
            $time_end = array_get($queryParams, 'audit_end_apply_time');
            $cashId = array_get($queryParams, 'audit_cash_id');
            $name = array_get($queryParams, 'audit_name');
            $mobile = array_get($queryParams, 'audit_mobile');
            $nickname = array_get($queryParams, 'audit_nickname');
        } elseif ($status == 1) {
            $time_start = array_get($queryParams, 'wait_apply_time');
            $time_end = array_get($queryParams, 'wait_verify_time');
            $cashId = array_get($queryParams, 'wait_cash_id');
            $name = array_get($queryParams, 'wait_name');
            $mobile = array_get($queryParams, 'wait_mobile');
            $nickname = array_get($queryParams, 'wait_nickname');
        } elseif ($status == 2) {
            $time_start = array_get($queryParams, 'tran_start_verify_time');
            $time_end = array_get($queryParams, 'tran_end_verify_time');
            $cashId = array_get($queryParams, 'tran_cash_id');
            $name = array_get($queryParams, 'tran_name');
            $mobile = array_get($queryParams, 'tran_mobile');
            $nickname = array_get($queryParams, 'tran_nickname');
        }

        $download = array_get($queryParams, 'load');
        $limit = array_get($queryParams, 'limit', 10);
        $orderBy = array_get($queryParams, 'order_by', 'id');
        $asc = array_get($queryParams, 'asc', 'DESC');
        $offset = array_get($queryParams, 'offset', 0);

        $storeId = $this->store->id ;

        $cash = [];
        $wechat = [];
        $cashTime = [];
        $cash[] = ['store_id', '=', $storeId];

        if ($nickname) {
            $wechat[] = ['nickname', 'like', '%'."$nickname".'%'];
        }
        if ($mobile) {
            $cash[] = ['mobile', 'like', '%'."$mobile".'%'];
        }
        if ($name) {
            $cash[] = ['name', 'like', '%'."$name".'%'];
        }
        if ($cashId) {
            $cash[] = ['id', 'like', '%'."$cashId".'%'];
        }
        if ($status == 0) {
            if ($time_start) {
                $cashTime[] = ['apply_time', '>=', dayStart( $time_start )];
            }
            if ($time_end) {
                $cashTime[] = ['apply_time', '<=', dayEnd( $time_end )];
            }
        } elseif($status == 1) {
            if ($time_start) {
                $cashTime[] = ['apply_time', '>=', dayStart( $time_start )];
            }
            if ($time_end) {
                $cashTime[] = ['verify_time', '<=', dayEnd( $time_end )];
            }
        } elseif($status == 2) {
            if ($time_start) {
                $cashTime[] = ['verify_time', '>=', dayStart( $time_start )];
            }
            if ($time_end) {
                $cashTime[] = ['verify_time', '<=', dayEnd( $time_end )];
            }
        } else {
            return \Response::errorAjax('没有该类型记录!');
        }
        if ($status == 1) {
            /*status 1  待打款(包括 打款中(status 3))*/
            $cashResult=CommissionCashApply::whereIn('status', [CommissionCashApply::WAIT_PAID, CommissionCashApply::PAYING,
                CommissionCashApply::PAY_FAILED])->where($cash)->where($cashTime)->whereHas('user', function(Builder $query) use ( $wechat ) {
                $query->where($wechat);
            });
        } else {
            $cashResult= CommissionCashApply::whereHas('user', function(Builder $query) use ($wechat) {
                $query->where($wechat);
            })->where('status',$status)->where($cash)->where($cashTime);
        }

        $info['total']=$cashResult->count();
        //  在已打款状态下 按照打款时间排序
        $orderBy = $status == 2 ? "verify_time" : $orderBy;
        $info['rows'] = $cashResult->offset($offset)->limit($limit)->orderBy($orderBy, $asc)->get();
        if ($info['rows']) {
            foreach ($info['rows'] as $v) {
                $v['amount'] = number_format($v['amount'], 2);
                if ($v['wait_amount'] > 0 ) {
                    $v['wait_amount'] = number_format($v['wait_amount'], 2);
                }
                if ($v['pay_amount'] > 0 ) {
                    $v['pay_amount'] = number_format($v['pay_amount'], 2);
                }
                $v['nickname'] = $v['user']['nickname'];
                $v['head_image_url'] = $v['user']['head_image_url'];
                unset($v['user']);
            }
        }

        return \Response::ajax($info);
    }

    /*打款详情*/
    public function cashDetail(Request $request)
    {
        $storeId = StoreService::getCurrentID();
        $queryParams = $request->all();
        $status = array_get($queryParams, 'status');
        $cashId = array_get($queryParams, 'cash_id');
        $userId = array_get($queryParams, 'user_id');

        $info = [];
        if (!in_array($status, array(0,1,2,3))) {
            return \Response::ajax('请求状态错误!');
        }
        /*用户信息*/
        $memberDetail = Member::with('user')->where('user_id', $userId)
            ->where('store_id', $storeId)
            ->with(['memberLevel', 'commissionSettings'])
            ->first();

        if (!$memberDetail) {
            return \Response::errorAjax('查不到此用户!');
        } else if ($memberDetail['commissionSettings'] == null) {
            return \Response::errorAjax('查不到店铺设置!');
        }

        /*用户下级数量*/
        $memberOneCount =Member::where('father_id', $userId)->where('store_id', $storeId)->count();
        $memberTwoCount =Member::where('grand_father_id', $userId)->where('store_id', $storeId)->count();
        $memberThrCount =Member::where('great_grand_father_id', $userId)->where('store_id', $storeId)->count();

        /*打款详情*/
        if ($status == 1) {
            $cashDetail=CommissionCashApply::with([
                'cashDetails' => function(HasMany $query) use ($cashId, $status){
                        $query->where('commission_cash_apply_id', $cashId)->where('status', $status);
                    }
                ])->with('commissionSettings')
                ->where('id', $cashId)
                ->where('store_id', $storeId)
                ->whereIn('status', [ CommissionCashApply::WAIT_PAID, CommissionCashApply::PAYING, CommissionCashApply::PAY_FAILED])
                ->first();
        } else {
            $cashDetail=CommissionCashApply::with(['cashDetails' => function(HasMany $query) use ($cashId, $status){
                $query->where('cash_apply_id', $cashId)->where('status', $status);
            }])->with('commissionSettings')
                ->where('id', $cashId)
                ->where('store_id', $storeId)
                ->where('status', $status)
                ->first();
        }

        if ($cashDetail) {
            $cashDetail['amount'] = number_format($cashDetail['amount'] , 2);
            $cashDetail['pay_amount'] = number_format($cashDetail['pay_amount'] , 2);
            $cashDetail['wait_amount'] = number_format($cashDetail['wait_amount'] , 2);

            foreach ($cashDetail['cashDetails'] as $v) {
                $v['amount'] = number_format($v['amount'] , 2);
                $v['pay_amount'] = number_format($v['pay_amount'] , 2);
                $v['wait_amount'] = number_format($v['wait_amount'] , 2);
            }
        }
        //  店铺佣金比例
        $memberDetail->commission = $memberDetail->memberLevel->commision;
        $memberDetail->father_commision = $memberDetail->memberLevel->father_commision;
        $memberDetail->grand_father_commision = $memberDetail->memberLevel->grand_father_commision;
        $memberDetail->great_grand_father_commision = $memberDetail->memberLevel->great_grand_father_commision;
        /*用户的下级数量*/
        $info['user_one'] = $memberOneCount;
        $info['user_two'] = $memberTwoCount;
        $info['user_thr'] = $memberThrCount;
        /*分销层级*/
        $info['level'] = $memberDetail->commissionSettings->level;

        $info['user'] = $memberDetail;
        $info['cash'] = $cashDetail;

        unset($memberDetail->commissionSettings);
        return \Response::ajax($info);
    }

    /*佣金打款*/
    public function cashPayMember(Request $request)
    {
        $storeId = StoreService::getCurrentID();
        $cashId = $request->input('cash_id');
        $status = $request->input('status');
        if (!$cashId ||!$status) {
            $info['message'] = 'cash_id or status not exist!';
            return \Response::ajax($info);
        }

        $info = [];
        /*排除打款成功订单*/
        $cashInfo = CommissionCashApply::where('store_id', $storeId)
            ->where('id', $cashId)->where('status', '<>', CommissionCashApply::PAY_SUCCESS)
            ->first();
        if (!$cashInfo) {
            return \Response::errorAjax('该订单不存在或已经完成打款', 400);
        }
        $userId = $cashInfo->distribution_user_id;
        /*status  1:微信,2:支付宝*/
        if ($status === 1) {
            /*更新提现申请表  订单状态为打款中*/
            CommissionCashApply::where('id', $cashId)->update([
                'status'=>'3',
                'verify_time'=>date('Y-m-d H:i:s',time())
            ]);

            CommissionCashApply::cashCommission($userId, $cashId, $storeId);

            $info['message'] = true;
            $info['content'] = "打款申请已提交,系统自动打款中,请耐心等待.";
            return \Response::ajax($info);
        } else if($status === 2) {
            //现在不支持
            $info['message'] = false;
            $info['content'] = "暂时不支持支付宝打款.";
            return \Response::ajax($info);
        }
        $info['message'] = false;
        $info['content'] = "打款申请失败.";
        return \Response::ajax($info);
    }
}
