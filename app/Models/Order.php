<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order currentStore()
 * @property string|null $store_code
 * @property float $discount_fee
 * @property float $post_fee
 * @property string|null $receiver_name
 * @property string|null $receiver_mobile
 * @property string|null $receiver_city
 * @property string|null $receiver_district
 * @property string|null $receiver_address
 * @property string|null $post_type
 * @property string|null $post_no
 * @property string|null $post_code
 * @property string|null $post_name
 * @property string $fee_type
 * @property string|null $body
 * @property string|null $detail
 * @property string|null $attach
 * @property string|null $error_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAttach($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDiscountFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereErrorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereFeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePostFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePostName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePostNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereReceiverAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereReceiverCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereReceiverDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereReceiverMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereReceiverName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereStoreCode($value)
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order searchBy($where)
 * @property string|null $form_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Refund[] $refunds
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereFormId($value)
 * @property string $name 商品标题作为此标题的值
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereName($value)
 * @property int|null $closed
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereClosed($value)
 */
class Order extends Model
{
    //
    use ModelTrait,
        StoreTrait,
        SoftDeletes,
        Notifiable;
    /**
     * 支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款
     * */
    const STATUS = [
        'ALL'   => '',
        'WAIT' => 'WAIT',
        'CANCEL' => 'CANCEL',
        'PAID' => 'PAID',
        'SEND' => 'SEND',
        'COMPLETED' => 'COMPLETED'
    ];

    const POST_TYPE = [
        'NONE' => '不需要快递',
        'SF' => '顺风快递',
        'YUNDA' => '韵达快递',
        'YTO' => '圆通快递',
        'STO' => '申通快递',
        'ZTO' => '中通快递',
        'BEST' => '百事通快递',
        'TTK' => '天天快递',
        'EMS' => '邮政速递'
    ];

    /**
     * 退款状态字典
     * */
    const REFUND_STATUS = [
        'REFUND_APPLYING' => 'REFUNDING',
        'REFUND_PASS'     => 'REFUNDED',
        'REFUND_REFUSED'  => 'REFUSED',
        'REFUND_CLOSED'   => 'CLOSED'
    ];

    const STATUS_SYNC_SEARCH = [
        'ALL'   ,
        'WAIT'  ,
        'CANCEL',
        'PAID'  ,
        'SEND'  ,
        'COMPLETED'
    ];

    const STATUS_ZH_CN = [
        'ALL'  => '全部',
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

    protected $fillable = [
            'code',
            'buyer_user_id' ,
            'num' ,
            'total_fee' ,
            'form_id',
            'payment_fee' ,
            'discount_fee' ,
            'post_fee' ,
            'receiver_name' ,
            'receiver_mobile',
            'receiver_city' ,
            'receiver_district' ,
            'receiver_address' ,
            'post_type',
            'post_no',
            'post_code' ,
            'post_name' ,
            'status' ,
            'cancel' ,
            'complete' ,
            'pay_type' ,
            'fee_type' ,
            'paid_at' ,
            'completed_at',
            'send_at',
            'error_code',
            'closed',
            'deleted_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Order $order){
            $order->code = uniqueCode();
        });
        static::saved(function(Order $order){

        });

        static::updated(function(Order $order){

        });
    }

    public function orderItems()
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
      $this->backStockNum();
      return  $order;
    }

    public  function backStockNum()
    {
        $orderItems = $this->orderItems;
        if($orderItems){
            $orderItems->map(function (OrderItem $orderItem){
                if($orderItem->product){
                    $product = $orderItem->product;
                    if($product){
                        $product->stock_num += $orderItem->num;
                        $product->save();
                    }
                }
                $merchandise = $orderItem->merchandise;
                if($merchandise){
                    $merchandise->stock_num += $orderItem->num;
                    $merchandise->save();
                }
            });
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

    public function toSearchableArray()
    {
        $order = $this->toArray();
        $order['status'] = array_search($order['status'], self::STATUS_SYNC_SEARCH);
        return $order;
    }

    public function refunds() : HasMany
    {
        return $this->hasMany('App\Models\Refund', 'order_id', 'id');
    }

    public static function buildFromShoppingCart($ids = [])
    {

    }
}
