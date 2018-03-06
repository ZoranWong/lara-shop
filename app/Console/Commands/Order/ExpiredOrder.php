<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class ExpiredOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '为支付订单一定时候后订单失效，不能支付';

    protected $date = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->date = strtotime(config('order.expires_at'));
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
        Order::where('completed_at', '<', $this->date)->where('status',  Order::STATUS['WAIT'])
            ->chunk(100, function (Collection $orders){
                $orders->map(function (Order $order){
                    $order->status = Order::STATUS['CANCEL'];
                    $order->cancel = Order::CANCEL_TYPE['AUTO'];
                    $order->save();
                });
            });
        return true;
    }
}
