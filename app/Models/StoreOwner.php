<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\UserRelationTrait;
use App\Models\Traits\WechatUserRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\StoreOwner
 *
 * @property int $store_id 店铺id
 * @property int $user_id 店铺拥有者用户id
 * @property string $union_id 微信多平台用户三方登录唯一标识
 * @property string $open_id 微信登录open_id
 * @property string $session_key 微信登录session
 * @property int $expire_in 微信登录session过期时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Store $store
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner findByOpenId($openId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereExpireIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner findBySession($sessionKey, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner findByUserId($userId, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner updateById($id, $data)
 */
class StoreOwner extends Model
{
    use ModelTrait;

    use UserRelationTrait;

    use WechatUserRelationTrait;

    const ROLE = 'store.owner';
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'store_owner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'user_id',
        'open_id',

        'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * 获取店铺。
     */
    public function store() : BelongsTo
    {
        return $this->belongsTo('App\Models\Store','store_id','id');
    }
    /**
     * 获取店铺管理人员信息
     * */
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function scopeFindByOpenId(\Illuminate\Database\Eloquent\Builder $query, $openId) : \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('open_id', $openId);
    }
}
