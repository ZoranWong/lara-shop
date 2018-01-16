<?php
namespace App\Models\Traits;
use Illuminate\Database\Query\Builder;

trait WechatUserRelationTrait
{
    public function scopeFindByOpenId(Builder $query ,string $openId, array  $columns = ['*']) : Builder
    {
        return $query->where('open_id', $openId)->first($columns);
    }

    public function scopeFindBySession(Builder $query ,string $sessionKey, array  $columns = ['*']) : Builder
    {
        return $query->where('session_key', $sessionKey)->where('expire_in', '>', time())->first($columns);
    }
}