<?php

namespace App\Models;

use App\Models\Traits\UserRelationTrait;
use App\Models\Traits\WechatUserRelationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\ModelTrait;
/**
 * App\Models\MiniProgramUser
 * 小程序普通用户model
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser findByOpenId($openId, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser findBySession($sessionKey, $columns = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser findByUserId($userId, $columns = array())
 * @property int $user_id 小程序登录普通用户id
 * @property string $open_id 微信登录open_id
 * @property string $union_id 微信多平台用户三方登录唯一标识
 * @property string $session_key 微信登录session
 * @property int $expire_in 微信登录session过期时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser whereExpireIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser whereOpenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser whereUnionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser whereUserId($value)
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MiniProgramUser onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MiniProgramUser withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MiniProgramUser withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MiniProgramUser searchBy($where)
 */
class MiniProgramUser extends Model
{
    //
    use ModelTrait, Notifiable, UserRelationTrait, WechatUserRelationTrait, SoftDeletes;
    /**
     * model关联数据库表单
     * */
    protected $table = 'mini_program_user';

    protected $fillable = [
        'user_id',
        'open_id',
        'union_id',
        'expire_in',
        'session_key'
    ];

    protected $hidden = [
        'open_id',
        'union_id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
