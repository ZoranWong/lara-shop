<?php

namespace App\Jobs\Jobs;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RefundAgree implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Order
     * */
    protected $order = null;
    /**
     * Create a new job instance.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //
        $this->order->orderItems->map(function (OrderItem $orderItem){
            $orderItem->status = OrderItem::STATUS['CANCEL'];
            $orderItem->cancel = OrderItem::CANCEL_TYPE[0];
        });
        $this->order->backStockNum();
    }
}
