<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\UserRelationTrait;
use App\Models\Traits\WechatUserRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\StoreOwner
 *
 * @property int $store_id 店铺id
 * @property int $user_id 店铺拥有者用户id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Store $store
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner findByUserId($userId, $columns = array())
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StoreOwner onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StoreOwner withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StoreOwner withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreOwner searchBy($where)
 */
class StoreOwner extends Model
{
    use ModelTrait,
        UserRelationTrait,
        SoftDeletes;

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
     * 用户关系
     * @return BelongsTo
     * */
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
