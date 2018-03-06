<?php

namespace App\Models\Distribution;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Distribution\Member whereFatherId($value)
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

    protected $fillable = ['*'];

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
            $item->head_image_url = isset($fansList[$item->user_id]) ? $fansList[$item->weapp_user_id]->head_image_url : '';
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


            if($item->apply_time) {
                $item->apply_time = date('Y-m-d H:i:s', $item->apply_time);
            }else {
                $item->apply_time = '';
            }
            if($item->join_time){
                $item->join_time = date('Y-m-d H:i:s', $item->join_time);
            } else {
                $item->join_time = '';
            }
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
}
