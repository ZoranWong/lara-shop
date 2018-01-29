<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int $parent_id 父级分类ID
 * @property string $name 分类名称
 * @property int $sort 分类排序
 * @property int $is_default 是否默认分组，1未默认，0不为默认
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category deleteByIds($ids)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category store()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Merchandise[] $merchandises
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category currentStore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category searchBy($where)
 */
class Category extends Model
{
    use ModelTrait ,StoreTrait , SoftDeletes;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id','name','parent_id','sort','is_default','sort'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function merchandises() : HasMany
    {
        return $this->hasMany('App\Models\Merchandise', 'category_id', 'id');
    }
}
