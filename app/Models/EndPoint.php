<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Routing\Router;

/**
 * App\Models\EndPoint
 *
 * @mixin \Eloquent
 * @property int $permission_id
 * @property string $name 接口名称
 * @property string $http_method http方法
 * @property string $route_name 路由名称
 * @property string $http_url_pattern 路由url正则表达式
 * @property int $disable 是否无效
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint whereDisable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint whereHttpMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint whereUpdatedAt($value)
 * @property string|null $params 路由参数JSON格式
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint httpUrlMatch(\Illuminate\Routing\Router $router)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint whereHttpUrlPattern($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EndPoint wherePermissionId($value)
 */
class EndPoint extends Model
{
    //
    protected $table = 'endpoint';

    const PARAM_PATTERN = '\{\?\}';

    protected $fillable = [

    ];

    public function scopeHttpUrlMatch(Builder $query, Router $router) : Builder
    {
        $router->currentRouteName();
        return $query->whereRaw('http_url_pattern REGEXP \'?\'', $router->current()->uri);
    }
}
