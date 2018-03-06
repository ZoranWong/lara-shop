<?php

namespace App\Console\Commands\Order;

use App\Models\Distribution\CommissionCashDetail;
use App\Models\Order;
use App\Models\Distribution\Order as DistributionOrder;
use App\Models\OrderCount;
use App\Models\OrderStaticsDaily;
use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SaleOrderCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:saleCount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $start = null;
    protected $end = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->start = strtotime(date('Y-m-d 00:00:00'));
        $this->end = strtotime(date('Y-m-d 23:59:59'));
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        Store::chunk(100, function (Collection $stores){
           $stores->map(function (Store $store){
               $staticsQuery = Order::where('store_id', $store->id)
                   ->whereIn('status', [Order::STATUS['PAID'], Order::STATUS['SEND'], Order::STATUS['COMPLETED']])
                   ->where('paid_at', '>=', $this->start)
                   ->where('paid_at', '<=', $this->end);
               $data['today_amount'] = $staticsQuery->sum('payment_fee');

               $data['today_sales'] = $staticsQuery->count();
               $staticsQuery = DistributionOrder::where('store_id', $store->id)
                   ->whereIn('status', [Order::STATUS['PAID'], Order::STATUS['SEND'], Order::STATUS['COMPLETED']])
                   ->where('paid_at', '>=', $this->start)
                   ->where('paid_at', '<=', $this->end);
               $data['today_distribution_amount'] = $staticsQuery->sum('payment_fee');
               $data['today_distribution_sales'] = $staticsQuery->count();

               $data['today_commission_amount'] = $staticsQuery->sum('total_commission');

               $staticsQuery = CommissionCashDetail::where('store_id', $store->id)
                   ->where('cash_time', '>=', $this->start)
                   ->where('cash_time', '<=', $this->end);
               $data['today_commission_paid_amount'] = $staticsQuery->sum('pay_amount');
               $staticsQuery = CommissionCashDetail::where('store_id', $store->id)
                   ->where('apply_time', '>=', $this->start)
                   ->where('apply_time', '<=', $this->end);
               $data['today_commission_apply_amount'] = $staticsQuery->sum('amount');
               $data['store_id'] = $store->id;
               $data['statics_date'] = date('Y-m-d');
               $static = OrderStaticsDaily::create($data);
               if(!$static){
                   log('order static action fail!');
               }
           });
        });
        return true;
    }
}
