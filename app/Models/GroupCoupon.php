<?php

namespace App\Models;

use App\Jobs\GroupCouponOverDate;
use App\Jobs\GroupCouponStart;
use App\Jobs\GroupOverDate;
use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\GroupCoupon
 *
 * @property int $id
 * @property string|null $code
 * @property int $store_id 店铺ID
 * @property string|null $store_code
 * @property int $merchandise_id 产品id
 * @property string|null $merchandise_code
 * @property string $name 团购活动名称
 * @property int $start_time 开始时间
 * @property int $end_time 结束时间
 * @property string $status 团购状态：WAIT 未开始 RUNNING 进行中 OVER_DATE 结束 INVALID 失效
 * @property int $member_num 团购人数
 * @property int $buy_limit_num 购买限制 等于0时不受限制
 * @property int $auto_patch 自动拼团
 * @property int $leader_prefer 团长优惠是否开启
 * @property float $leader_price 团长优惠价格
 * @property string $products_array sku团购配置：[{"id":"709","price":"100", "leader_price": "90"}]
 * @property float $price 团购价格
 * @property float $min_price 团购最小价格
 * @property float $max_price 团购最大价格
 * @property float $min_leader_price 团长优惠价格最小价格
 * @property float $max_leader_price 团长优惠价格最大价格
 * @property string $mini_program_code 小程序二维码
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon deleteByIds($ids)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCoupon onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon searchBy($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereAutoPatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereBuyLimitNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereLeaderPrefer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereLeaderPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereMaxLeaderPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereMaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereMemberNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereMerchandiseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereMinLeaderPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereMinPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereMiniProgramCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereProductsArray($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereStoreCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupCoupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCoupon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCoupon withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GroupOrder[] $groupOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $groups
 * @property-read \App\Models\Merchandise $merchandise
 * @property-read \App\Models\Store $store
 */
class GroupCoupon extends Model
{
    //
    use ModelTrait,SoftDeletes;

    const STATUS = [
        'WAIT' => 'WAIT',
        'RUNNING' => 'RUNNING',
        'OVER_DATE' => 'OVER_DATE',
        'INVALID' => 'INVALID'
    ];

    const STATUS_CN = [
        'WAIT' => '未开始',
        'RUNNING' => '进行中',
        'OVER_DATE' => '过期',
        'INVALID' => '失效'
    ];

    protected $table = "group_coupon";

    protected $casts = [
        'products_array' => 'array'
    ];

    public $oldStatus = '';

    protected $fillable = [
        'store_id',
        'store_code',
        'merchandise_id',
        'merchandise_code',
        'name',
        'start_time',
        'end_time',
        'status',
        'member_num',
        'buy_limit_num',
        'auto_patch',
        'leader_prefer',
        'leader_price',
        'products_array',
        'price',
        'min_price',
        'max_price',
        'mini_program_code',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function (GroupCoupon $groupCoupon){
            $groupCoupon->code = uniqueCode();
        });

        static::created(function (GroupCoupon $groupCoupon){
            //开启团购过期任务
            dispatch((new GroupCouponStart($groupCoupon->id))
                ->delay($groupCoupon->start_time - time())
                ->onQueue('group-coupon'));
        });

        static::retrieved(function (GroupCoupon $groupCoupon){
            $groupCoupon->oldStatus = $groupCoupon->status;
        });

        static::updated(function (GroupCoupon $groupCoupon){
            $groupCoupon->groups->map(function (Group $group) use(&$groupCoupon){
                $groupCoupon->statusChanged($group);
            });
        });
    }

    protected function statusChanged(Group $group)
    {
        if($this->status != $this->oldStatus){
            switch ($this->status){
                case GroupCoupon::STATUS['OVER_DATE'] :
                    $group->overDate();
                    break;
                case GroupCoupon::STATUS['INVALID'] :
                    $group->invalid();
                    break;
                case GroupCoupon::STATUS['RUNNING'] :
                    dispatch((new GroupCouponOverDate($this->id))
                        ->delay($this->end_time - $this->start_time)
                        ->onQueue('group-coupon'));
                    break;
            }
        }
    }

    public function start()
    {
        if($this->status == GroupCoupon::STATUS['WAIT']){
            $this->status = GroupCoupon::STATUS['RUNNING'];
            $this->save();
        }
    }

    public function store() : BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class, 'merchandise_id', 'id');
    }

    public function groups() : HasMany
    {
        return $this->hasMany(Group::class, 'group_coupon_id', 'id');
    }

    public function groupOrders() : HasMany
    {
        return $this->hasMany(GroupOrder::class, 'group_coupon_id', 'id');
    }

    public function overDate()
    {
        if(in_array($this->status, [GroupCoupon::STATUS['RUNNING']])){
            $this->oldStatus = $this->status;
            $this->status = GroupCoupon::STATUS['OVER_DATE'];
            $this->save();
        }
    }

    public function invalid()
    {
        if(!in_array($this->status, [GroupCoupon::STATUS['OVER_DATE'], GroupCoupon::STATUS['INVALID']])){
            $this->oldStatus = $this->status;
            $this->status = GroupCoupon::STATUS['INVALID'];
            $this->save();
        }
    }
}