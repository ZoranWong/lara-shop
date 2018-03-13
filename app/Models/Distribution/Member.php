<?php

namespace App\Models\Distribution;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Distribution\Member
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $store_id 代理的店铺id
 * @property int $user_id 代理的用户id
 * @property int $level_id 等级id
 * @property int|null $parent_id 上级代理id
 * @property int|null $grand_father_id 上上级代理id
 * @property int|null $great_grand_father_id grand_father_id父级代理id
 * @property int $depth 深度
 * @property string|null $path 路径：user id 用,隔开
 * @property float $amount 账户佣金余额
 * @property float $total_order_amount 分销订单金额总计
 * @property float $total_paid_commission_amount 已结算分销佣金总计
 * @property float $total_wait_commission_amount 待结算分销佣金总计
 * @property int $total_subordinate_num 下级分销商数量
 * @property int $total_cash_amount 提现佣金总计
 * @property int $apply_time 申请时间
 * @property int|null $join_time 加入或者审核时间
 * @property int $apply_status 申请状态0:未申请  1:待审核 2：通过 3拒绝
 * @property int $is_active 冻结状态 1:开启 0关闭
 * @property int $referrals 下级人数(不限级数统计)
 * @property string|null $full_name 姓名
 * @property string|null $mobile 电话
 * @property string|null $wechat 微信号
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereApplyStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereApplyTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereGrandFatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereGreatGrandFatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereJoinTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereReferrals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereTotalCashAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereTotalOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereTotalPaidCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereTotalSubordinateNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereTotalWaitCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereWechat($value)
 * @property-read \App\Models\Distribution\CommissionLevel $level
 * @property-read \App\Models\User $user
 * @property int|null $father_id 上级代理id
 * @property string active_Label
 * @property string nickname
 * @property string head_image_url
 * @property string father_nickname
 * @property string father_head_image_url
 * @property mixed|string apply_status_Label
 * @property string levelName
 * @property mixed lower
 * @property string sales_amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereFatherId($value)
 * @property-read \App\Models\Distribution\ApplySetting $commissionSetting
 * @property-read \App\Models\Distribution\CommissionLevel $memberLevel
 * @property int order_quantity
 * @property string total_commission_amount
 * @property-read \App\Models\User|null $father
 * @property-read \App\Models\User $grantFather
 * @property-read \App\Models\User $greatGrantFather
 * @property int total_payment_fee
 */
class Member extends Model
{
    //
    /**
     * 未申请
     *
     * @var int
     */
    const STATUS_NOT_APPLY = 0;

    /**
     * 待审核
     *
     * @var int
     */
    const STATUS_WAIT_CHECK = 1;

    /**
     * 通过
     *
     * @var int
     */
    const STATUS_PASS = 2;

    /**
     * 拒绝
     *
     * @var int
     */
    const STATUS_REFUSE = 3;

    /**
     * 开启
     *
     * @var int
     */
    const ACTIVE_OPEN = 1;

    /**
     * 冻结
     *
     * @var int
     */
    const ACTIVE_CLOSE = 0;

    protected $table = "distribution_member";

    protected $casts = [
        'is_active' => 'boolean',
        'apply_time' => 'datetime',
        'join_time'  => 'datetime'
    ];

    protected $fillable = [
        'id',
        'store_id',
        'user_id',
        'level_id',
        'father_id',
        'grand_father_id',
        'great_grand_father_id',
        'depth',
        'path',
        'amount',
        'total_order_amount',
        'total_paid_commission_amount',
        'total_wait_commission_amount',
        'total_subordinate_num',
        'total_cash_amount',
        'apply_time',
        'join_time',
        'apply_status',
        'is_active',
        'referrals',
        'full_name',
        'mobile',
        'wechat',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(CommissionLevel::class, 'level_id', 'id');
    }

    public static function setUserDetailTo(Collection $data)
    {
        $fansIdArr  = $data->pluck('father_id','user_id');
        $fansIdList = array_unique(array_merge($fansIdArr->keys()->all(),$fansIdArr->values()->all()));
        $fansList = User::whereIn('id', $fansIdList)
            ->select(['id', 'head_image_url', 'nickname'])
            ->get()
            ->keyBy('id');
        $data->map(function (Member $item) use ($fansList){
            $item->active_Label = $item->showActiveName();
            $item->nickname   = isset($fansList[$item->user_id]) ? $fansList[$item->user_id]->nickname : '';
            $item->head_image_url = isset($fansList[$item->user_id]) ? $fansList[$item->user_id]->head_image_url : '';
            $item->father_nickname   = isset($fansList[$item->father_id]) ? $fansList[$item->father_id]->nickname : '';
            $item->father_head_image_url   = isset($fansList[$item->father_id]) ? $fansList[$item->father_id]->head_image_url : '';
            // 待结算佣金总计
            $item->total_wait_commission_amount = "¥ " . number_format($item->total_wait_commission_amount, 2);
            // 已结算分销佣金总计
            $item->total_paid_commission_amount = "¥ " . number_format($item->total_paid_commission_amount, 2);
            // 已提现佣金
            $item->total_cash_amount = "¥ " . number_format($item->total_cash_amount, 2);
            // 分销订单金额总计
            $item->total_order_amount = "¥ " . number_format($item->total_order_amount, 2);

            $item->apply_status_Label = $item->showApplyStatus();
        });
        return $data;
    }

    public function showActiveName()
    {
        return $this->is_active == self::ACTIVE_OPEN ? '开启' : '关闭';
    }

    public function showApplyStatus()
    {
        $map = [];
        $map[self::STATUS_NOT_APPLY] = '未申请';
        $map[self::STATUS_WAIT_CHECK] = '待审核';
        $map[self::STATUS_PASS] = '通过';
        $map[self::STATUS_REFUSE] = '已拒绝';

        return isset($map[$this->apply_status]) ? $map[$this->apply_status] : '';
    }

    public function memberLevel() : BelongsTo
    {
        return $this->belongsTo(CommissionLevel::class, 'level_id', 'id');
    }
    public function commissionSetting() : HasOne
    {
        return $this->hasOne(ApplySetting::class, 'store_id', 'store_id');
    }

    public function father() : BelongsTo
    {
        return $this->belongsTo(User::class, 'father_id', 'id');
    }

    public function grantFather() : BelongsTo
    {
        return $this->belongsTo(User::class, 'grant_father_id', 'id');
    }

    public function greatGrantFather() : BelongsTo
    {
        return $this->belongsTo(User::class, 'great_grant_father_id', 'id');
    }
}
