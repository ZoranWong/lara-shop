<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * relation with user model
 * */
trait UserRelationTrait
{
    /**
     *local scope方法：使用userId查找数据
     * @param Builder $query
     * @param int $userId
     * @return  Builder
     * */
    public function scopeFindByUserId(Builder $query, int $userId, array $columns = ['*']) : Builder
    {
        return $query->where('user_id', $userId)->first($columns);
    }
}