<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Zizaco\Entrust\Contracts\EntrustPermissionInterface;
use Zizaco\Entrust\Traits\EntrustPermissionTrait;

/**
 * App\Models\Permission
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 权限唯一名称标示
 * @property string|null $display_name 权限显示名称
 * @property string|null $description 权限描述
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission updateById($id, $data)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property int|null $parent_id 父级权限id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereParentId($value)
 * @property-read \App\Models\Menu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission searchBy($where)
 */
class Permission extends Model implements EntrustPermissionInterface
{
    use ModelTrait,
        EntrustPermissionTrait;

    const ALL_RIGHT = '*';
    /**
     * model关联数据库表单
     * @var string $table
     * */
    protected $table = 'permission';
    /**
     * 可以批量赋值属性
     * @var array $fillable
     * */
    protected $fillable = [
        'id',
        'name',
        'display_name',
        'description'
    ];

    /**
     * 关联角色
     * @return  BelongsToMany
     * */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\Role', 'permission_role', 'permission_id', 'role_id');
    }

    /**
     * 关联用户
     * @return BelongsToMany
     * */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'permission_user', 'permission_id', 'user_id');
    }

    /**
     * @return HasOne
     * */
    public function menu() : HasOne
    {
        return $this->hasOne('App\Models\Menu', 'permission_id', 'id');
    }
}
