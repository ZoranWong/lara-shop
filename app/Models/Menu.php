<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use App\Renders\Traits\AdminBuilder;
use App\Renders\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Input;

/**
 * App\Models\Menu
 *
 * @mixin \Eloquent
 * @property int $permission_id
 * @property string $text 菜单名称
 * @property string $icon 菜单图标
 * @property string $url 路由url
 * @property int $is_active 是否active
 * @property int $visible 是否visible
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu wherePermissionId($value)
 * @property int|null $parent_permission_id 父级权限id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereParentPermissionId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Menu[] $children
 * @property-read \App\Models\Menu|null $parent
 * @property-read \App\Models\Permission|null $parentPermission
 * @property-read \App\Models\Permission $permission
 * @property int $id
 * @property int|null $parent_id 父级菜单id
 * @property int $order 排序
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Menu searchBy($where)
 */
class Menu extends Model
{
    //
    use ModelTrait,ModelTree;
    protected $table = 'menu';

    protected $fillable = [
        'permission_id',
        'parent_permission_id',
        'text',
        'icon',
        'url',
        'active',
        'is_visible',
        'order'
    ];


    public function parent() : BelongsTo
    {
        return $this->belongsTo('App\Models\Menu', 'parent_permission_id', 'permission_id');
    }

    public function permission() :BelongsTo
    {
        return $this->belongsTo('App\Models\Permission', 'permission_id', 'id');
    }

    public function parentPermission() : BelongsTo
    {
        return $this->belongsTo('App\Models\Permission', 'parent_permission_id', 'id');
    }

    public function children() : HasMany
    {
        return $this->hasMany('App\Models\Menu', 'parent_permission_id', 'permission_id');
    }

    public function roles() : BelongsToMany
    {
        return $this->permission()->first()->roles();
    }
}
