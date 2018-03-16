<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\Controller;
use App\Models\Distribution\Member;
use App\Models\Distribution\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DistributionOrderController extends Controller
{

    /**
      * 订单详情 *
      * @param Request $request
      * @return \Response
      * @throws
      * @optional  int  status
      * 佣金状态(1.筛选出所有已结算订单, 2未结算, 空值时 输出全部)
      */
    public function orderListDetail(Request $request)
    {
        try {
            $queryParams = $request->all();
            $offset = array_get($queryParams, 'page', 1);
            $statusCommission = array_get($queryParams,'status');

            $storeId = array_get($queryParams, 'store_id', null);
            $this->user = $request->user();
            $userId = $this->user->id;
            $limit = 10;
            $offset = $offset <= 1 ? 0 : intval($offset-1) * $limit;

            /*判断用户身份*/
            $ifUser = Member::where('user_id', $userId)
                ->where('store_id', $storeId)
                ->count();
            if ($ifUser == 0) {
                throw new \Exception('你不是分销商!');
            }
            /*筛选佣金状态  默认全部,1为已结算,否则归类未结算(0未结算 1已结算 2已退单)*/
            $statusOne = 0;
            $statusTwo = 1;
            $statusThree = 2;
            if ($statusCommission) {
                if ($statusCommission == 1) {
                    $statusOne = 1;
                    $statusTwo = 1;
                    $statusThree = 1;
                } elseif ($statusCommission == 2) {
                    $statusOne = 0;
                    $statusTwo = 0;
                    $statusThree = 0;
                }
            }
            $data = Order::where('store_id', $storeId)
                ->whereIn('commission_settle_status',[$statusOne, $statusTwo, $statusThree])
                ->where(function(Builder $query) use ($userId){
                    $query->orWhere('buyer_user_id', $userId)
                        ->orWhere('father_id', $userId)
                        ->orWhere('grand_father_id', $userId)
                        ->orWhere('great_grand_father_id', $userId);
                })
                ->orderBy('id','DESC')
                ->offset($offset)
                ->limit($limit)
                ->get()->map(function (Order $order){
                    /*退款佣金总计*/
                    $order->total_commission = number_format($order->total_commission, 2);
                    $order->commission = number_format($order->commission, 2);
                    $order->father_commission = number_format($order->father_commission, 2);
                    $order->grand_father_commission = number_format($order->grand_father_commission, 2);
                    $order->great_grand_father_commission = number_format($order->great_grand_father_commission, 2);
                    $order->payment_fee = number_format($order->payment_fee, 2);
                    $order->refund_fee = number_format($order->refund_fee, 2);
                    return $order;
                });
            return \Response::ajax($data);
        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }
}
