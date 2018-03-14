<?php

namespace App\Models\Distribution;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Distribution\Order
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $store_id 店铺id
 * @property int $order_id 订单ID
 * @property int $order_item_id 订单子项id
 * @property int|null $father_id 分销id
 * @property int|null $grand_father_id 上上级代理id
 * @property int|null $great_grand_father_id grand_father_id父级代理id
 * @property float $commission 自购佣金
 * @property float $father_commission 分销佣金
 * @property float $grand_father_commission 上上级分销佣金
 * @property float $great_grand_father_commission grand_father上级分销佣金
 * @property int $should_settled_at 应当结算时间
 * @property int|null $real_settled_at 实际结算时间
 * @property int $commission_status 自购佣金状态:0正常 1冻结(不计入分销商佣金账户)
 * @property int $father_commission_status 直接分销商佣金状态:0正常 1冻结(不计入分销商佣金账户)
 * @property int $grand_father_commission_status 上级分销佣金状态:0正常 1冻结(不计入分销商佣金账户)
 * @property int $great_grand_father_commission_status 上上级分销商佣金状态:0正常 1冻结(不计入分销商佣金账户)
 * @property int $commission_settle_status 佣金结算状态 0未结算 1已结算2已退单
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereCommissionSettleStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereCommissionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereFatherCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereFatherCommissionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereGrandFatherCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereGrandFatherCommissionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereGrandFatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereGreatGrandCommissionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereGreatGrandFatherCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereGreatGrandFatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereRealSettledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereShouldSettledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereUpdatedAt($value)
 * @property float|null $payment_fee
 * @property string|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order wherePaymentFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereStatus($value)
 * @property float|null $total_commission
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereTotalCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereFatherId($value)
 * @property int|null $buyer_user_id
 * @property-read \App\Models\User|null $buyer
 * @property-read \App\Models\User $distributionFather
 * @property-read \App\Models\User $distributionGrantFather
 * @property-read \App\Models\User $distributionGreatGrantFather
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereBuyerUserId($value)
 * @property float|null $refund_fee
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Order whereRefundFee($value)
 * @property int $great_grand_commission_status 上上级分销商佣金状态:0正常 1冻结(不计入分销商佣金账户)
 */
class Order extends Model
{
    //
    const STATUS_UNSETTLED = 0;
    const STATUS_SETTLED = 1;
    const STATUS_REFUND = 2;

    const COMMISSION_STATUS_NORMAL = 0;

    const COMMISSION_STATUS_FORBIDDEN = 1;

    protected $table = "distribution_order";

    protected $fillable = [
        'id',
        'store_id',
        'buyer_user_id',
        'order_id',
        'order_item_id',
        'father_id',
        'grant_father_id',
        'great_grant_father_id',
        'payment_fee',
        'total_commission',
        'commission',
        'father_commission',
        'grant_father_commission',
        'great_grant_father_commission',
        'should_settled_at',
        'real_settled_at',
        'commission_status',
        'father_commission_status',
        'grant_father_commission_status',
        'great_grant_father_commission_status',
        'commission_settle_status',
        'status'
    ];

    public function store() : BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function buyer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_user_id', 'id');
    }

    /**
     * order relation
     * @return BelongsTo
     * */
    public function order() : BelongsTo
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id', 'id');
    }

    public function distributionFather() : BelongsTo
    {
        return $this->belongsTo(User::class, 'father_d', 'id');
    }

    public function distributionGrantFather() : BelongsTo
    {
        return $this->belongsTo(User::class, 'grant_father_id', 'id');
    }

    public function distributionGreatGrantFather() : BelongsTo
    {
        return $this->belongsTo(User::class, 'great_grant_father_id', 'id');
    }

}
