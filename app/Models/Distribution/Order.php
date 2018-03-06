<?php

namespace App\Models\Distribution;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Distribution\Order
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $store_id 店铺id
 * @property int $order_id 订单ID
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
 * @property int $great_grand_commission_status 上上级分销商佣金状态:0正常 1冻结(不计入分销商佣金账户)
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
 */
class Order extends Model
{
    //
    protected $table = "distribution_order";
}
