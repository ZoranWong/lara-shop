<?php

namespace App\Models\Distribution;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DistributionApplySetting
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $store_id 店铺id
 * @property int $apply_type 申请条件 0无条件 1指定商品 2满额
 * @property int $info_status 申请时是否填写资料  0不填写  1填写
 * @property int $mobile_status 是否发送手机号码  0不发送  1发送
 * @property int $check_way 审核方式:1不需要审核 2需要审核
 * @property int|null $level
 * @property int|null $commission_days
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereApplyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereCheckWay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereCommissionDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereInfoStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereMobileStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\ApplySetting whereUpdatedAt($value)
 */
class ApplySetting extends Model
{
    //
    const APPLY_TYPE_NONE = 0;

    const APPLY_TYPE_BUY_GOOD = 1;

    const APPLY_TYPE_FULL_AMOUNT = 2;

    const APPLY_TYPE = [
        self::APPLY_TYPE_NONE,
        self::APPLY_TYPE_BUY_GOOD,
        self::APPLY_TYPE_FULL_AMOUNT
    ];


    const INFO_STATUS_NO_NEED = 0;

    const INFO_STATUS_NEED = 1;

    const INFO_STATUS = [
        self::INFO_STATUS_NO_NEED,
        self::INFO_STATUS_NEED
    ];

    const MOBILE_STATUS_FORBIDDEN = 0;

    const MOBILE_STATUS_OPEN = 1;

    const MOBILE_STATUS = [
        self::MOBILE_STATUS_FORBIDDEN,
        self::MOBILE_STATUS_OPEN
    ];

    const CHECK_FORBIDDEN = 1;

    const CHECK_MUST    = 2;

    const CHECK_WAY = [
        self::CHECK_FORBIDDEN,
        self::CHECK_MUST
    ];

    protected $table = "distribution_apply_setting";
    protected $fillable = [
        'id',
        'store_id',
        'apply_type',
        'info_status',
        'mobile_status',
        'check_way',
        'level',
        'commission_days'
    ];

}
