<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PermissionRole
 *
 * @mixin \Eloquent
 * @property int $permission_id 权限id
 * @property int $role_id 角色id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole whereUpdatedAt($value)
 * @property-read \App\Models\Permission $permission
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole searchBy($where)
 */
class PermissionRole extends Model
{
    use ModelTrait;
    /**
     * model关联数据库表单
     * */
    protected $table = 'permission_role';

    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    /**
     * 权限关系
     * @return BelongsTo
     * */
    public function permission() : BelongsTo
    {
        return $this->belongsTo('App\Models\Permission', 'permission_id', 'id');
    }

    /**
     * 角色关系
     * @return BelongsTo
     * */
    public function role()  : BelongsTo
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }
}
