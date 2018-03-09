<?php

namespace App\Models\Distribution;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
 * @property-read \App\Models\Distribution\Member $member
 * @property int|null $distribution_user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Distribution\CommissionCashDetail[] $cashDetails
 * @property-read \App\Models\Distribution\ApplySetting $commissionSettings
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionCashApply whereDistributionUserId($value)
 */
class CommissionCashApply extends Model
{
    //
    const WAIT_AUDIT = 0;

    const WAIT_PAID = 1;

    const PAY_SUCCESS  = 2;

    const PAYING = 3;

    const PAY_FAILED = 4;

    const FRONT_SHOW_SUCCESS = 1;

    const FRONT_SHOW_WAIT = 0;

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
        'id',
        'store_id',
        'distribution_member_id',
        'distribution_user_id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,  'distribution_user_id', 'id');
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(Member::class,  'distribution_member_id', 'id');
    }

    /*佣金提现 打款   招商宝*/
    public static function cashCommission($userId, $cashId, $storeId)
    {
        $member = Member::where('user_id',0)
            ->where('store_id', $storeId)
            ->where('distribution_user_id', $userId)
            ->with('user')
            ->with('cashApply')
            ->first();

        if (!$member) {
            return false;
        } elseif (!$member['full_name']) {
            return false;
        } elseif (!$member->user) {
            return false;
        } elseif (!$member->user->miniProgramUser || !$member->user->miniProgramUser->open_id) {
            return false;
        } elseif (!$userId) {
            return false;
        } elseif (!$cashId) {
            return false;
        }

        $cashObj = [
            'openid' => $member->user->miniProgramUser->open_id ,
            'desc' =>' 企业付款',
            'reUserName' => $member->full_name,
            'spbillCreateIp' => '121.41.13.15',
            'fans_id' => $userId,
            'cash_id'=>$cashId
        ];

        return true;
    }

    public function commissionSettings() : HasOne
    {
        return $this->hasOne(ApplySetting::class, 'store_id', 'store_id');
    }

    public function cashDetails() : HasMany
    {
        return $this->hasMany(CommissionCashDetail::class, 'commission_cash_apply_id', 'id');
    }
}
