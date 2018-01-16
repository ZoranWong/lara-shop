<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Role
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 角色唯一标示名称
 * @property string|null $display_name 角色显示名称
 * @property string|null $description 角色描述
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role updateById($id, $data)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserRole[] $userRoles
 */
class Role extends Model
{
    use ModelTrait;
    /**
     * model关联数据库表单
     * */
    protected $table = 'role';

    protected $fillable = [
        'id',
        'name',
        'display_name',
        'description'
    ];

    /**
     * 关联用户
     * @return BelongsToMany
     * */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'user_role', 'role_id', 'user_id');
    }

    /**
     * 用户角色关系
     * @return  HasMany
     * */
    public function userRoles() : HasMany
    {
        return $this->hasMany('App\Models\UserRole', 'role_id', 'id');
    }

    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\Permission', 'permission_role', 'role_id', 'permission_id');
    }
}
