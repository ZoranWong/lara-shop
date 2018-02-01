<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class Completed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '订单自动签收';

    protected $date = null;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->date = strtotime(config('order.completed'));
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
        Order::where('send_at', '<', $this->date)->where('status', Order::STATUS['SEND'])
            ->chunk(100, function (Collection $orders){
                $orders->map(function (Order $order){
                    $order->status = Order::STATUS['COMPLETED'];
                    $order->save();
                    $order->orderItems->map(function (OrderItem $orderItem){
                        $orderItem->status = OrderItem::STATUS['COMPLETED'];
                        $orderItem->save();
                    });
                });
            });
        return true;
    }
}
