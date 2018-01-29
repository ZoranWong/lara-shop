<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller
{
    public function __construct(Page $page)
    {
        $this->page = $page;
        parent::__construct(function () use (&$page){
            $input = app('request');
            $page->status = $status = $input->input('status', null);
            $where = [];
            $refundStatus = Order::REFUND_STATUS;
            $orderStatus = Order::STATUS;
            if($status && isset($refundStatus[$status])) {
                $where[] = ['whereHas' => ['orderItems.refund', function(Builder $query) use($status){
                    $query->where('status', Refund::STATUS[Order::REFUND_STATUS[$status]]);
                }]];
            } else if($status && isset($orderStatus[$status])) {
                $where[] = ['whereHas' => ['orderItems', function(Builder $query) use($status){
                    $query->where('status', OrderItem::STATUS[$status]);
                }]];
            }
            unset($input['status']);

            return $where;
        });
    }

    public function sendMerchandise(int $id, Request $request)
    {
        $postType = $request->input('post_type', null);
        $postNo = $request->input('post_no', null);
        $data = $request->all();
        if($postType && $postNo && Order::POST_TYPE[$postType]){
           $order = Order::find($id);
           $order->post_type = $postType;
           $order->post_no = $postNo;
           $order->status = Order::STATUS['SEND'];
           $order->send_at = time();
           $result = $order->save();
           $order->orderItems->map(function (OrderItem $orderItem){
               $orderItem->refund->status = Refund::STATUS['CLOSED'];
               $orderItem->refund->save();
               $orderItem->store->amount += $orderItem->refund->total_fee;
               $orderItem->store->save();
           });
           if(!$result){
               return response()->errorAjax('发货失败');
           }else{
               return response()->ajax('发货成功');
           }
        }else{
            return response()->errorAjax('参数错误'.json_encode(Input::json()));
        }
    }
}
