<?php

namespace App\Models\Distribution;

use App\Models\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Distribution\CommissionLevel
 *
 * @property int $id
 * @property int $store_id 店铺id
 * @property string $name 分销等级名称
 * @property int|null $upgrade_type 0 不自动升级 1满额自动升级
 * @property float|null $reach_amount 升级规则为1时，指定额度，单位：元
 * @property int|null $allocation 1-佣金比例 2-固定额度
 * @property int $commission_days 佣金到账天数
 * @property int|null $level 分销层级
 * @property int $commission_status 自购佣金状态1开启0关闭
 * @property float $commission 自购佣金,小于1
 * @property float $father_commission 一级佣金,小于1
 * @property float $grand_father_commission 二级佣金,小于1
 * @property float $great_grand_father_commission 三级佣金,小于1
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereAllocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereCommissionDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereCommissionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereFatherCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereGrandFatherCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereGreatGrandFatherCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereReachAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\CommissionLevel whereUpgradeType($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Store $store
 */
class CommissionLevel extends Model
{
    //
    const ALLOCATION_PERCENTAGE = 1;

    const ALLOCATION_STATIC = 2;
    const ALLOCATION = [
        self::ALLOCATION_PERCENTAGE,
        self::ALLOCATION_STATIC
    ];

    const COMMISSION_FORBIDDEN = 0;
    const COMMISSION_OPEN = 1;

    const COMMISSION_STATUS = [
        self::COMMISSION_FORBIDDEN,
        self::COMMISSION_OPEN
    ];

    const UPGRADE_AUTO = 1;

    const NOT_UPGRADE_AUTO = 0;

    protected $table = "commission_level";

    /*
      * @property int $id
     * @property int $store_id 店铺id
     * @property string $name 分销等级名称
     * @property int|null $upgrade_type 0 不自动升级 1满额自动升级
     * @property float|null $reach_amount 升级规则为1时，指定额度，单位：元
     * @property int|null $allocation 1-佣金比例 2-固定额度
     * @property int $commission_days 佣金到账天数
     * @property int|null $level 分销层级
     * @property int $commission_status 自购佣金状态1开启0关闭
     * @property float $commission 自购佣金,小于1
     * @property float $father_commission 一级佣金,小于1
     * @property float $grand_father_commission 二级佣金,小于1
     * @property float $great_grand_father_commission 三级佣金,小于1
     * */

    protected $fillable = [
        'id',
        'store_id',
        'name',
        'level',
        'upgrade_type',
        'reach_amount',
        'allocation',
        'commission_status',
        'commission',
        'father_commission',
        'grant_father_commission',
        'great_grant_father_commission'
    ];

    public function store() : BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
