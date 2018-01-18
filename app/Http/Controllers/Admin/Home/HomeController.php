<?php

namespace App\Http\Controllers\Admin\Home;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Http\Controllers\Admin\Home\Store\Page;
use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\Order;
use App\Models\OrderCount;
use App\Services\StoreService;

class HomeController extends Controller
{
    protected $data = [];

    /**
     * @var Page $page
     * */
    protected $page = null;

    /**
     * @var array $store
     * */
    protected $store = null;

    public function __construct(Page $page)
    {
        $this->store = $store = StoreService::getCurrentStore();
        $storeCondition = ($store['id'] == 0 || !isset($store['id'] ) ? '' : "store_id={$store['id']} and");
        $todaySumCount = $this->orderSumCount($storeCondition);
        $todayMoneySum = $this->orderMoneyCount('today', $storeCondition);
        $result = \DB::select("select wait_pay.num as wait_pay_num, wait_send.num as wait_send_num, wait_receive.num as "
            ."wait_receive_num, complete.num as complete_num, today_count.num as today_sum_count, today_pay_fee.payment_fee_sum as payment_fee_sum from"
            ." (select count(*) as num from `order` where {$storeCondition} status = 'WAIT') as wait_pay,"
            ." (select count(*) as num from `order` where {$storeCondition} status = 'PAID') as wait_send,"
            ." (select count(*) as num from `order` where {$storeCondition} status = 'SEND') as wait_receive,"
            ." (select count(*) as num from `order` where {$storeCondition} status = 'COMPLETED') as complete,"
            ." {$todaySumCount} as today_count,"
            ." {$todayMoneySum} as today_pay_fee");
        $this->data = collect($result[0]);
        $this->page = $page;
    }

    protected function taskAndWxAuth(int $waitPayNum, int $waitSendNum, int $waitReceiveNum, int $completeNum)
    {
        $task = [
            'waitPayNum' => $waitPayNum,
            'waitSendNum' => $waitSendNum,
            'waitReceiveNum' => $waitReceiveNum,
            'completeNum' => $completeNum
        ];
        $this->page->taskAndWxAuth($task);
    }

    public function index() : BasePage
    {
        $waitPayNum = $this->data['wait_pay_num'];
        $waitSendNum = $this->data['wait_send_num'];
        $waitReceiveNum = $this->data['wait_receive_num'];
        $completeNum = $this->data['complete_num'];
        $todaySumCount = $this->data['today_sum_count'];
        $todayMoneySum = $this->data['payment_fee_sum'] ? $this->data['payment_fee_sum'] : 0;
        $sales = OrderCount::where('store_id', $this->store['id'])->first(['yes_sales', 'last_week_sales']);;
        $yesterdayMoneySum = $sales['yes_sales'] ? $sales['yes_sales'] : 0;
        $lastWeekSum = $sales['last_week_sales'] ? $sales['last_week_sales'] : 0;
        $this->cards($todaySumCount, $todayMoneySum, $yesterdayMoneySum, $lastWeekSum);
        if(\Auth::user()->hasRole(['store.owner','store.manager'])){
            $this->taskAndWxAuth($waitPayNum, $waitSendNum, $waitReceiveNum, $completeNum);
            $this->page->managerBox();
        }

        return $this->page;
    }

    protected function cards(int $todaySumCount, int $todayMoneySum, int $yesterdayMoneySum, $lastWeekSum)
    {
        $cards = [
            [
                'title' => '今日订单总数',
                'num'  => $todaySumCount,
                'icon' => 'shopping-cart',
                'bg_color' => 'aqua'
            ],
            [
                'title' => '今日销售总额',
                'num'  =>  '¥'.$todayMoneySum,
                'icon' => 'cny',
                'bg_color' => 'green'
            ],
            [
                'title' => '昨日销售总额',
                'num'  => '¥'.$yesterdayMoneySum,
                'icon' => 'cny',
                'bg_color' => 'yellow'
            ],
            [
                'title' => '近七天销售总额',
                'num'  => '¥'.$lastWeekSum,
                'icon' => 'cny',
                'bg_color' => 'red'
            ]
        ];

        $this->page->cards($cards);
    }

    /*
    * 店铺今日订单统计
    */
    private function orderSumCount($storeCondition)
    {
        $selectTime = $this->getTime('today');

        $startTime = date('Y-m-d H:i:s', $selectTime['startTime']);
        $endTime = date('Y-m-d H:i:s', $selectTime['endTime']);
        $status = '(';
        collect(Order::STATUS)->map(function ($value) use (&$status){
            $status .= ($value != 'CANCEL') ? "'".$value."',": '';
        });
        $status = substr($status, 0, strlen($status) - 1);
        if($status == '('){
            $status .= '*';
        }
        $status .= ')';
        return '(select count(*) as num from `order` where '.$storeCondition.' created_at > \''.$startTime
            .'\' and created_at < \''.$endTime.'\' and status in '. $status.')';
    }

    /*
    ** 店铺销售金额统计
    */
    private function orderMoneyCount($select, $storeCondition)
    {
        $selectTime = $this->getTime($select);

        $startTime = $selectTime['startTime'];
        $endTime = $selectTime['endTime'];
        return '(select sum(payment_fee) as payment_fee_sum from `order` where '.$storeCondition.' created_at > \''.$startTime
            .'\' and created_at < \''.$endTime.'\')';
    }
    /*
    ** 获取时间
    */
    private function getTime($selectTime)
    {
        $select = [];

        switch ($selectTime) {
            case 'today':
                $select['startTime'] = mktime(0,0,0,date('m'),date('d'),date('Y'));
                $select['endTime'] = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
                break;
            case 'yesterday':
                $select['startTime'] = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
                $select['endTime'] = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
                break;
            case 'lastWeek':
                $select['startTime'] =      mktime(0,0,0,date('m'),date('d')-6,date('Y'));
                $select['endTime'] = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
                break;
            default:
                break;
        }

        return $select;
    }
}
