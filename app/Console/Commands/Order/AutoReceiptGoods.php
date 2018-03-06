<?php

namespace App\Console\Commands\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class AutoReceiptGoods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:autoReceiptGoods';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动收货';

    protected $date = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->date = strtotime(config('order.auto_completed_at'));
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
                });
            });
        return true;
    }
}
