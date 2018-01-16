<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\UserRelationTrait;
use App\Models\Traits\WechatUserRelationTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StoreManager
 *
 * @property int $store_id 店铺id
 * @property string|null $union_id 微信多平台用户三方登录唯一标识
 * @property int $user_id 店铺管理者用户id
 * @property string $open_id 微信登录open_id
 * @property string $session_key 微信登录session
 * @property int $expire_in 微信登录session过期时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Store $store
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereExpireIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager findByOpenId($openId, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager findBySession($sessionKey, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager findByUserId($userId, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StoreManager updateById($id, $data)
 */
class StoreManager extends Model
{
    use ModelTrait;

    use UserRelationTrait;

    use WechatUserRelationTrait;

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
        'user_id',
        'open_id',
        'session_key',
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
}
