<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;
use EasyWeChat\Payment\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class PaymentController extends Controller
{
    //
    protected $payment = null;

    protected $jssdk = null;

    protected $app = null;

    public function __construct(Application $application)
    {
        $this->payment = $application->order;
        $this->jssdk = $application->jssdk;
        $this->app = $application;
        parent::__construct();
    }

    public function pay(Request $request, int $orderId)
    {
        if(!$orderId){
            return response()->errorApi();
        }
        $order = Order::find($orderId);
        if($order->status != Order::STATUS['WAIT']){
            return response()->errorApi();
        }else{
            try {
                $user  = $this->user();
                $miniProgramUser = $user->miniProgramUser;
                if(! $miniProgramUser){
                    return response()->errorApi('小程序未登录');
                }
                $openid = $miniProgramUser->open_id;
                $order = Order::with(['orderItems'])->find($orderId);
                if(!$order){
                    return response()->errorApi('订单不存在');
                }
                $detail = '';
                foreach ($order->orderItems as $item){
                    $detail .= $item->name.'|';
                }
                $body = '走客网商城';
                $domainApi = config('domain.api');
                $attributes = [
                    'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
                    'body'             => $body,
                    'detail'           => $detail,
                    'out_trade_no'     => $order->code,
                    'total_fee'        => $order['payment_fee'] * 100, // 单位：分
                    'notify_url'       => "http://{$domainApi}/user/order/{$order->id}/pay/notify",
                    'openid'           => $openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识
                ];
                $result = $this->payment->unify($attributes);
                if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
                    $prepayId   = $result->prepay_id;
                    //保存form_id
                    $order->form_id = $prepayId;
                    $config = $this->jssdk->sdkConfig($prepayId);
                    return response()->api($config);
                } else {
                    if($result->return_code == 'SUCCESS'){
                        return response()->errorApi('统一下单错误:'.$result->err_code_des);
                    }else{
                        return response()->errorApi('统一下单错误:'.$result->return_msg);
                    }

                }
            } catch (\Exception $e) {
                return response()->errorApi('支付错误：'.$e->getMessage());
            }
        }
    }

    public function notify($orderId)
    {
        $response = $this->app->handlePaidNotify(function ($message, $fail) use($orderId){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $orderCode = $message['out_trade_no'];
            $order = Order::with('orderItems')->find($orderId);

            if (!$order || $orderCode != $order->code || $order->paid_at) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    $order->paid_at = time(); // 更新支付时间为当前时间
                    $order->status = Order::STATUS['PAID'];
                    $order->orderItems->map(function(OrderItem $orderItem){
                        $store = Store::find($orderItem->store_id);
                        $store->amount += $orderItem->total_fee;
                        $store->save();
                    });
                    // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    $order->error_code = array_get($message, 'err_code');
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });
        return $response->send();
    }
}
