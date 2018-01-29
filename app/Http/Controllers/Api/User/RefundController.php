<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Validation\ValidationException;

class RefundController extends Controller
{
    //
    public function apply(Request $request)
    {
        try{
            $this->validate($request, [
                'order_id' => 'required|integer|exists:order,id',
                'order_item_id' => 'required|integer|exists:order_item,id',
                'refund_fee' => 'required|numeric|min:0.01'
            ], [
                'order_id.required' => '缺少订单ID',
                'order_item_id.required' => '缺少子订单id',
                'refund_fee.required' => '缺少退款金额',
                'order_id.integer' => '订单id类型为整数',
                'order_item_id.integer' => '子订单ID类型为整数',
                'refund_fee.numeric' => '退款金额为数字类型',
                'order_id.exists' => '订单数据中不存在需要退款的订单记录',
                'order_item_id.exists' => '没有需要退款的子订单记录'
            ]);
            $orderId = $request->input('order_id', null);
            $orderItemId = $request->input('order_item_id', null);
            $refundFee = $request->input('refund_fee', 0);
            if(Refund::where('order_id', $orderId)->where('order_item_id', $orderItemId)->count() > 0){
                return response()->errorApi('已经申请退款');
            }
            $userId = $this->user()->id;
            if($orderItemId && $orderId && $refundFee > 0){
                $order = Order::with('orderItems')->where('buyer_user_id', $userId)->find($orderId);
                $orderItem = $order->orderItems->where('id', $orderItemId)->where('buyer_user_id', $userId)->first();
                if(!$orderItem || !$order){
                    return response()->errorApi('订单错误');
                }
                if($refundFee > $orderItem->total_fee){
                    return response()->errorApi('退款金额超出订单总金额！');
                }
                $store =  $orderItem->store;
                $store->amount -= $orderItem->total_fee;
                $store->save();
                $data = [
                    'store_id'         => $orderItem->store_id,
                    'store_code'       => $orderItem->store_code,
                    'merchandise_id'   => $orderItem->merchandise_id,
                    'merchandise_code' => $orderItem->merchandise_code,
                    'product_id'       => $orderItem->product_id,
                    'product_code'     => $orderItem->product_code,
                    'order_id'         => $order->id,
                    'order_code'       => $order->code,
                    'order_item_id'    => $orderItem->id,
                    'order_item_code'  => $orderItem->code,
                    'buyer_user_id'    => $userId,
                    'total_fee'        => $orderItem->total_fee,
                    'refund_fee'       => $refundFee,
                    'status'           => Refund::STATUS['REFUNDING'],
                    'refund_account'   => Refund::REFUND_ACCOUNT['REFUND_SOURCE_UNSETTLED_FUNDS'],
                    'refund_reason'    => $request->input('refund_reason', null)
                ];
                $refund = Refund::create($data);
                return response()->api($refund);
            }else{
                return response()->errorApi('退款申请失败');
            }
        }catch (\Exception $exception){
            if($exception instanceof ValidationException){
                return response()->errorApi($exception->errors());
            }
            return response()->exceptionApi($exception);
        }
    }

    public function close($id)
    {
        $refund = Refund::find($id);
        if(!$refund){
            return response()->errorApi('退款申请不存在');
        }
        $refund->status = Refund::STATUS['CLOSED'];
        $result = $refund->save();

        if($result){
            return response()->api('关闭退款申请');
        }else{
            return response()->errorApi('关闭退款申请失败');
        }
    }
}
