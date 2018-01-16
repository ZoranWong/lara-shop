<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Models\Traits\UserRelationTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Token
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id 用户id
 * @property string $token 用户登录token
 * @property int $expire_in token有效时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token findByUserId($userId, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token whereExpireIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Token whereUserId($value)
 */
class Token extends Model
{
    //
    use ModelTrait;
    use UserRelationTrait;
    protected $table = "token";

    protected $fillable = [
        'user_id',
        'token',
        'expire_in'
    ];
}
