<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\UserRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserRole
 *
 * @mixin \Eloquent
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole findByUserId($userId, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserRole updateById($id, $data)
 */
class UserRole extends Model
{
    //
    protected $table = 'role_user';
    use ModelTrait;
    use UserRelationTrait;

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
