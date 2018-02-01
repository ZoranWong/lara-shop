<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Refund
 *
 * @mixin \Eloquent
 * @property string $code 订单子项编号
 * @property int $order_id 订单id
 * @property string $order_code 订单编号
 * @property int $store_id 店铺id
 * @property string $store_code 店铺编号
 * @property int $buyer_user_id 买家id
 * @property int $merchandise_id 商品id
 * @property string $merchandise_code 产品编号
 * @property int $product_id 产品id
 * @property string $product_code 产品编号
 * @property int $order_item_id 订单子项id
 * @property string $order_item_code 订单子项编号
 * @property float $total_fee 订单总额
 * @property float $refund_fee 退款金额
 * @property string $status 退款状态
 * @property string $fee_type 退款货币
 * @property string $refund_account 退款资金来源
 * @property float $settlement_refund_fee 应结退款金额
 * @property float $settlement_total_fee 应结订单金额
 * @property float $cash_fee 现金支付金额
 * @property float $cash_refund_fee 现金退款金额
 * @property string $cash_fee_type 现金支付币种
 * @property string $error_code 错误码
 * @property string $coupon_type 代金券类型
 * @property float $coupon_refund_fee 代金券退款总金额
 * @property string|null $coupon_refund 代金券退款{id:XX,fee:XX}
 * @property int $coupon_refund_count 退款代金券使用数量
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund deleteByIds($ids)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Refund onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCashFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCashFeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCashRefundFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCouponRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCouponRefundCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCouponRefundFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCouponType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereErrorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereFeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereMerchandiseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereOrderItemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereRefundAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereRefundFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereSettlementRefundFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereSettlementTotalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereStoreCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereTotalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Refund withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Refund withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund searchBy($where)
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereId($value)
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereDeletedAt($value)
 * @property string|null $refund_reason 退款理由
 * @property string|null $refuse_reason 拒绝理由
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereRefundReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereRefuseReason($value)
 * @property int $refund_product 是否退货
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Refund whereRefundProduct($value)
 */
class Refund extends Model
{
    //
    use ModelTrait, SoftDeletes, Notifiable;

    const STATUS = [
        'REFUNDING' => 'REFUNDING',
        'REFUNDED'  => 'REFUNDED',
        'CLOSED'    => 'CLOSED',
        'REFUSED'   => 'REFUSED'
    ];

    const REFUND_ACCOUNT = [
        'REFUND_SOURCE_UNSETTLED_FUNDS' => 'REFUND_SOURCE_UNSETTLED_FUNDS',
        'REFUND_SOURCE_RECHARGE_FUNDS'  => 'REFUND_SOURCE_RECHARGE_FUNDS'
    ];
    protected $table = 'refund';

    protected $fillable = [
        'code',
        'store_id'   ,
        'store_code' ,
        'merchandise_id',
        'merchandise_code',
        'product_id',
        'product_code',
        'order_id',
        'order_code',
        'order_item_id',
        'order_item_code',
        'buyer_user_id',
        'total_fee',
        'refund_fee',
        'status',
        'refund_account',
        'refund_reason'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Refund $refund){
            $refund->code = uniqueCode();
        });
    }
}
