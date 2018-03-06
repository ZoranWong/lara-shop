<?php

namespace App\Models\Distribution;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Distribution\CommissionCashApply
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $store_id 店铺id
 * @property int $distribution_member_id 分销商id
 * @property string $mobile 电话
 * @property string $name 姓名
 * @property int $apply_time 申请时间
 * @property int|null $verify_time 审核时间
 * @property float $amount 申请金额
 * @property float $pay_amount 已经打款额度
 * @property float $wait_amount 等待打款金额
 * @property string|null $remark 状态异常时备注
 * @property int $status 状态 0待审核 1待打款 2已打款 3打款中 4打款失败
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereApplyTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereDistributionMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply wherePayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereVerifyTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereWaitAmount($value)
 * @property-read \App\Models\User $user
 */
class CommissionCashApply extends Model
{
    //
    const WAIT_AUDIT = 0;

    const WAIT_PAID = 1;

    const PAY_SUCCESS  = 2;

    const PAYING = 3;

    const PAY_FAILED = 4;

    const APPLY_STATUS = [
        self::WAIT_AUDIT,
        self::WAIT_PAID,
        self::PAY_SUCCESS,
        self::PAYING,
        self::PAY_FAILED
    ];

    protected $table = "commission_cash_apply";

    protected $casts = [

    ];

    protected $fillable = [

    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,  'distribution_member_id', 'id');
    }
}
