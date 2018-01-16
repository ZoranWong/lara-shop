<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nickname 用户昵称
 * @property string $head_image_url 用户头像
 * @property string $sex 用户性别
 * @property string $mobile 用户登录手机号码
 * @property string $password 登录密码
 * @property string|null $remember_token 记住我token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User search($key)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereHeadImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User updateById($id, $data)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Store[] $managerStore
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Store[] $ownStore
 */
class User extends Authenticatable
{
    //
    use Notifiable;

    use ModelTrait;

    use EntrustUserTrait { restore as private restoreA; }

    use SoftDeletes { restore as private restoreB; }

    const SUPER_ADMIN_ID = 1;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
        'head_image_url',
        'sex',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * 解决 EntrustUserTrait 和 SoftDeletes 冲突
     */
    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    /**
     * 限制查询只包括某个关键字的用户。
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query,string  $key) : \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('nickname', 'like', $key . '%');
    }

    /**
     * 限制查询只包括活跃的用户。
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query) : \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('active', 1);
    }

    public function ownStore() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\Store', 'store_owner', 'store_id', 'user_id');
    }

    public function managerStore() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\Store', 'store_manager', 'store_id', 'user_id');
    }

}
