<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class OverDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:closed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单完成后一定时间后不能在退款';

    protected $date = null;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->date = date('Y-m-d h:i:s', strtotime(config('order.over_date')));
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
        Order::where('created_at', '<', $this->date)->where('status', Order::STATUS['SEND'])
            ->chunk(100, function (Collection $orders){
                $orders->map(function (Order $order){
                    $order->status = Order::STATUS['CANCEL'];
                    $order->cancel = Order::CANCEL_TYPE[2];
                    $order->save();
                    $order->orderItems->map(function (OrderItem $orderItem){
                        $orderItem->status = OrderItem::STATUS['CANCEL'];
                        $orderItem->cancel = OrderItem::CANCEL_TYPE[2];
                        $orderItem->save();
                    });
                });
            });
        return true;
    }
}
