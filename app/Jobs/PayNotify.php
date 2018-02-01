<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PayNotify implements ShouldQueue
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
        \DB::beginTransaction();
        try{
            $orderItems = $this->order->orderItems;
            $orderItems->map(function (OrderItem $orderItem){
                //商品库存
                $merchandise = $orderItem->merchandise;
                $merchandise->stock_num -= $orderItem->num;
                $merchandise->save();
                //规格产品库存
                $product = $orderItem->product;
                if($product) {
                    $product->stock_num -= $orderItem->num;
                    $product->save();
                }
                //店铺账户金额
                $store = $orderItem->store;
                $store->amount += $orderItem->total_fee;
                $store->save();
            });
            \DB::commit();
        }catch (\Exception $exception){
            \DB::rollBack();
            throw $exception;
        }
    }
}
