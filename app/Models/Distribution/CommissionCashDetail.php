<?php

namespace App\Models\Distribution;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Distribution\CommissionCashDetail
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $store_id 店铺id
 * @property int $commission_cash_apply_id 申请单ID
 * @property int $distribution_member_id 分销商id
 * @property string $mobile 电话
 * @property string $name 姓名
 * @property int $apply_time 申请时间
 * @property int|null $cash_time 审核时间
 * @property float $amount 申请金额
 * @property float $pay_amount 已经打款额度
 * @property float $wait_amount 等待打款金额
 * @property string|null $remark 状态异常时备注
 * @property int $status 状态 0待打款 1已打款 2打款中
 * @property string|null $trade_no 订单号(微信转账唯一凭证,
 *             打款失败再用此字段,避免重复打款)
 * @property string|null $payment_no 支付单号(微信支付 查询凭证)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereApplyTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereCashTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereCommissionCashApplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereDistributionMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail wherePayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail wherePaymentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereTradeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashDetail whereWaitAmount($value)
 */
class CommissionCashDetail extends Model
{
    //
    protected $table = "commission_cash_detail";
}
