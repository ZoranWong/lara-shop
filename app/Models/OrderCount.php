<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderCount
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $store_id 商铺ID
 * @property float $today_sum 今日销售金额
 * @property float $yes_sales 昨日销售金额
 * @property float $last_week_sales 前七天销售金额
 * @property int $today_sales 今日销量
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount whereLastWeekSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount whereTodaySales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount whereTodaySum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount whereYesSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCount updateById($id, $data)
 */
class OrderCount extends Model
{
    //
    use ModelTrait;
    protected $table = 'order_count';
}
