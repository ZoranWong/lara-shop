<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class Closed extends Command
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
        $this->date = strtotime(config('order.closed_at'));
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
        Order::where('completed_at', '<', $this->date)->where('status', Order::STATUS['COMPLETED'])
            ->chunk(100, function (Collection $orders){
            $orders->map(function (Order $order){
                $order->closed = true;
                $order->save();
                $order->orderItems->map(function (OrderItem $orderItem){
                    $orderItem->closed = true;
                    $orderItem->save();
                });
            });
        });
        return true;
    }
}
