<?php
namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStaticsDaily;
use App\Models\Store;
use App\Services\StoreService;

class OrderController extends Controller
{
    /**
     * @var Store
     * */
    protected $store = null;

    public function __construct()
    {
        $this->store = StoreService::getCurrentStore();
    }

    public function chartDaily()
    {
        $storeId = $this->store->id;
        $time = time();
        $today = date('Y-m-d',$time);
        $timeStart = dayStart();
        $timeEnd = dayEnd();
        /*当前店铺今日新增分销商*/
        $memberCountNew = 0;
        /*当前店铺订单数量*/
        $orderCount = $storeId ? ($this->store->where('paid_at', '>=', $timeStart)
            ->where('paid_at', '<=', $timeEnd)
            ->count()) : 0;
        /*当前店铺佣金总数*/
        $orderCommission = 0;
        /*当前店铺订单总额*/
        $orderAmount = 0;
        if ($orderCount > 0) {
            /*当前店铺订单总额*/
            $orderAmount=$this->store->where('paid_at', '>=', $timeStart)
                ->where('paid_at', '<=', $timeEnd)
                ->sum('good_fee');
        }
        $info = [];
        $info['day'] = [];
        $currentDay = [];
        /*获取当天和 前六天的日期(昨天,前天,大前天....)*/
        for ($i=0;$i<7;$i++) {
            $info['day'][] .= date("m月d日", ($time - 86400 * $i));
        }
        for ($i=1;$i<7;$i++) {
            $currentDay[] .= date("Y-m-d", ($time - 86400 * $i));
        }

        $totalInfo = $storeId ? (OrderStaticsDaily::where("store_id", $storeId)
            ->whereIn('current_day', $currentDay)
            ->get()) : null;
        /*今日分销订单*/
        $totalCount= $totalInfo ? $totalInfo->count() : 0;
        $info['orders'] = [$orderCount, 0, 0, 0, 0, 0, 0];
        $info['member'] = [$memberCountNew, 0, 0, 0, 0, 0, 0];
        $info['amount'] = [number_format($orderAmount, 2), 0, 0, 0, 0, 0, 0];
        $info['commission'] = [number_format($orderCommission, 2), 0, 0, 0, 0, 0, 0];
        /*如果之前有记录,则优先展示之前的记录*/
        if ($totalCount > 0) {
            $totalInfo->map(function ( OrderStaticsDaily $statics ) use( &$info, $currentDay){
                $key = array_search($statics->statics_date, $currentDay);
                $info['orders'][$key] .= $statics->today_sales;
                $info['amount'][$key] .= number_format($statics->today_amount, 2);
                $info['commission'][$key] .= number_format($statics->today_commission_amount, 2);
                $info['member'][$key] .= 0;
            });
        }
        return \Response::ajax($info);
    }
}