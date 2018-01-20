<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $code 订单编码
 * @property int $store_id 店铺ID
 * @property int $buyer_user_id 购买者用户id
 * @property int $num 商品数量
 * @property float $total_fee 总价
 * @property float $payment_fee 实付金额
 * @property string $status 支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款
 * @property string $cancel 取消人：BUYER 买家取消 SELLER 卖家取消 AUTO 自动取消
 * @property string $complete 取消人：BUYER 买家确认 SELLER 卖家确认 AUTO 自动确认
 * @property string $pay_type 支付方式：WX_PAY 微信支付 ALI_PAY 支付宝支付 UNION_PAY 银联支付 OTHER 其他支付
 * @property int $paid_at 支付时间
 * @property int $completed_at 签收时间或者订单完成时间
 * @property int $send_at 发货时间
 * @property string $refund 退款 {refund_no:退款编码, total_fee: 订单总金额, refund_fee:退款金额}
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCancel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaymentFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereSendAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTotalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order updateById($id, $data)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order store()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withoutTrashed()
 */
class Order extends Model
{
    //
    use ModelTrait,
        StoreTrait,
        SoftDeletes;
    /**
     * 支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款
     * */
    const STATUS = [
        'WAIT' => 'WAIT',
        'CANCEL' => 'CANCEL',
        'PAID' => 'PAID',
        'SEND' => 'SEND',
        'COMPLETED' => 'COMPLETED'
    ];

    const STATUS_ZH_CN = [
        'WAIT' => '待支付',
        'CANCEL' => '取消订单',
        'PAID' => '待发货',
        'SEND' => '待收货',
        'COMPLETED' => '交易完成'
    ];

    /**
     * 取消人：BUYER 买家取消 SELLER 卖家取消 AUTO 自动取消
     * */
    const CANCEL_TYPE = [
        'BUYER',
        'SELLER',
        'AUTO'
    ];

    /**
     *订单完成：BUYER 买家确认 SELLER 卖家确认 AUTO 自动确认
     * */
    const COMPLETE_TYPE = [
        'BUYER',
        'SELLER',
        'AUTO'
    ];

    protected $table = 'order';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function ordersItem()
    {
      return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function user()
    {
      return $this->belongsTo('App\Models\User','buyer_user_id');
    }

    public function cancel($cancel='BUYER')
    {
      $order = $this;
      $order->status = self::STATUS['CANCEL'];
      $order->cancel = $cancel;//取消人
      $order->save();
      $this->backStockNum($order->id);
      return  $order;
    }

    public static function backStockNum($orderId)
    {
        if(!is_array($orderId)){
            $orderId = [$orderId];
        }
        $orderItems = OrderItem::with(['merchandise', 'product'])->whereIn('order_id',$orderId)->get();
        if($orderItems){
            foreach($orderItems as $item){
                if($item['product']){
                    $product = $item['product'];
                    if($product){
                        $product->stock_num += $item['num'];
                        $product->save();
                    }
                }
                $merchandise = $item['merchandise'];
                if($merchandise){
                    $merchandise->stock_num += $item['num'];
                    $merchandise->save();
                }
            }
        }
    }


    /**
     * 计算最大退款(不含邮费)
     * @param array $array
     * @param float $orderPayment
     * @param float $postFee
     * @return array
     * */
    public static function countRefundNoPost(array  $array = [] , float $orderPayment , $postFee)
    {
        $payment = array_sum($array);
        $i = 1;
        $total = count($array);
        $discount = $payment - $orderPayment + $postFee;
        $tempPayment = 0;
        $data = [];
        foreach ($array as $key => $value) {
            if($orderPayment <= $postFee) {
                $data[$key] = 0;
            }else {
            if($i >= $total) {
              $data[$key] = max($payment - $tempPayment - $discount , 0);
            }else {
              $data[$key] = max(floor($value - $discount * $value / $payment) , 0);
            }
            }
        $i = $i + 1;
        $tempPayment = $data[$key] + $tempPayment;
        }
        return $data;
    }
}
