<?php

namespace App\Jobs;

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
     * @var OrderItem
     * */
    protected $orderItem = null;
    /**
     * Create a new job instance.
     * @param Order $order
     */
    public function __construct(OrderItem $orderItem)
    {
        //
        $this->orderItem = $orderItem;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //
        $this->orderItem->status = OrderItem::STATUS['CANCEL'];
        $this->orderItem->cancel = OrderItem::CANCEL_TYPE[0];
        $this->orderItem->save();
        $this->orderItem->backStockNum();
    }
}
