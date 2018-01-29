<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\UserRelationTrait;
use App\Models\Traits\WechatUserRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\StoreManager
 *
 * @property int $store_id 店铺id
 * @property int $user_id 店铺管理者用户id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Store $store
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager findByUserId($userId, $columns = array())
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StoreManager onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StoreManager withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StoreManager withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager searchBy($where)
 */
class StoreManager extends Model
{
    use ModelTrait,
        UserRelationTrait,
        SoftDeletes;

    const ROLE = 'store.manager';
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'store_manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'user_id'
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
    public function store()
    {
        return $this->hasOne('App\Models\Store','id','store_id');
    }

    public static function searchManagerStore($userId,$name,$offset = 0,$limit = 1000)
    {
        $modelObj = (new static)->with(['store' => function ($query) use ($name) {
            $name && $query->where('name', 'like', "{$name}%");
        }]);

        $user = User::find($userId);
        if(!$user) {
            return [];
        }

        if($userId != User::SUPER_ADMIN_ID && !$user->hasRole(['admin']) ) {
            $modelObj = $modelObj->where('user_id',$userId);
        } else {
            $modelObj = Store::where('name', 'like', "{$name}%");
        }
        $list = $modelObj->offset($offset)->limit($limit)->get();
        $data = [];
        if($list) {
            foreach ($list as $k => $v) {
                if($v->store){
                    $data[] = $v->store;
                } else {
                    $data[] = $v;
                }
            }
        }
        return $data;
    }

    public static function checkManagerStore($userId,$storeId)
    {
        if($userId == User::SUPER_ADMIN_ID) {
            return true;
        }
        $user = User::find($userId);
        if(!$user) {
            return false;
        }
        if($user->hasRole(['admin'])) {
            return true;
        }

        $storeInfo = self::where('user_id',$userId)->where('store_id',$storeId)->first();

        return $storeInfo ? true : false;
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
