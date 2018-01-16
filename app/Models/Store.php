<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\WechatUserRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * App\Models\Store
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StoreManager[] $managerRelations
 * @property-read \App\Models\StoreOwner $ownerRelation
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 店铺名称
 * @property string $logo_url 店铺logo图片
 * @property float $amount 店铺余额
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereUpdatedAt($value)
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store updateById($id, $data)
 */
class Store extends Model
{
    use ModelTrait;

    use Notifiable;

    protected $table = 'store';

    protected $fillable = [
        'user_id',
        'open_id',
        'union_id',
        'expire_in',
        'session_key'
    ];

    public function ownerRelation() : HasOne
    {
        return $this->hasOne('App\Models\StoreOwner', 'store_id', 'id');
    }

    public function owner() : User
    {
        return $this->ownerRelation->user;
    }

    public function managerRelations() : HasMany
    {
        return $this->hasMany('App\Models\StoreManager', 'store_id', 'id');
    }

    public function managers() : Collection
    {
        return $this->managerRelations->map(function (StoreManager $manager)
        {
            return $manager->user;
        });
    }
}
