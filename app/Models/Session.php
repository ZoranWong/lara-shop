<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Session
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $payload
 * @property int $last_activity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session searchBy($where)
 */
class Session extends Model
{
    //
    use ModelTrait;

    protected $table = 'sessions';
}
