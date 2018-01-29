<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\UserRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\UserRole
 *
 * @mixin \Eloquent
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole findByUserId($userId, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole updateById($id, $data)
 * @property int $user_id 用户id
 * @property int $role_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserRole onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserRole withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserRole withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole searchBy($where)
 * @method static bool|null forceDelete()
 */
class UserRole extends Model
{
    //
    protected $table = 'role_user';
    use ModelTrait,
        UserRelationTrait,
        SoftDeletes;

    protected $fillable = [
        'role_id',
        'user_id'
    ];

    /**
     * @return BelongsTo
     * */
    public function role() : BelongsTo
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }
}
