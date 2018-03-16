<?php

namespace App\Models;

use App\Models\Distribution\Member;
use App\Models\Traits\ModelTrait;
use App\Renders\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Contracts\EntrustUserInterface;
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
 * @property-read \App\Models\StoreOwner $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchBy($where)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShoppingCart[] $shoppingCarts
 * @property-read \App\Models\MiniProgramUser $miniProgramUser
 * @method static bool|null forceDelete()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Distribution\Order[] $distributionOrders
 * @property-read \App\Models\Distribution\Member $distributionMember
 */
class User extends Authenticatable implements EntrustUserInterface
{
    //
    use Notifiable;

    use ModelTrait;

    use AdminBuilder;

    use EntrustUserTrait {
        restore as protected restoreEntrust;
    }


    use SoftDeletes {
        restore as protected restoreSoftDelete;
    }

    const SUPER_ADMIN_ID = 1;

    const SEX = [
        'UNKNOWN',
        'MALE',
        'FEMALE'
    ];

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
        $this->restoreEntrust();
        $this->restoreSoftDelete();
    }

    protected static function boot()
    {
        static::restoring(function (User $user) {

        });
    }

    /**
     * 限制查询只包括某个关键字的用户。
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, string $key): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('nickname', 'like', $key . '%');
    }

    /**
     * 限制查询只包括活跃的用户。
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('active', 1);
    }

    public function ownStore(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Store::class, 'store_owner', 'store_id', 'user_id');
    }

    public function managerStore(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Store::class, 'store_manager', 'store_id', 'user_id');
    }

    public function owner(): HasOne
    {
        return $this->hasOne(\App\Models\StoreOwner::class, 'user_id', 'id');
    }

    public function miniProgramUser(): HasOne
    {
        return $this->hasOne(\App\Models\MiniProgramUser::class, 'user_id', 'id');
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(\App\Models\Token::class, 'user_id', 'id');
    }

    public function getToken()
    {
        $token = \Cache::get($this->id);
        return $token ? $token : (($token = $this->tokens()->where('expire_in',
            '>', time())->first(['token'])) ? $token['token'] : null);
    }

    public function setToken($token)
    {
        $this->tokens->push($token);
        return $this->tokens;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(\App\Models\Order::class, 'buyer_user_id', 'id');
    }

    public function shoppingCarts(): HasMany
    {
        return $this->hasMany(\App\Models\ShoppingCart::class, 'buyer_user_id', 'id');
    }

    public function distributionOrders(): HasMany
    {
        return $this->hasMany(\App\Models\Distribution\Order::class, 'buyer_user_id', 'id');
    }

    public function distributionMember() : HasOne
    {
        return $this->hasOne(Member::class, 'user_id', 'id');
    }
}
