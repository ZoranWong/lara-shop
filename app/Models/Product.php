<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $merchandise_id 商品ID
 * @property string $code 规格产品编号
 * @property array $spec_array JSON存储规格数组,数组元素{name:"XX",id:"XX",value:"XX","tip":"XX"}
 * @property float $sell_price 售价
 * @property float $market_price 原价
 * @property int $stock_num 库存
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereMarketPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSpecArray($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    //
    use ModelTrait;

    protected $table = 'product';

    protected $casts = [
        'spec_array' => 'array'
    ];

    protected $fillable = [
        'code',
        'sell_price',
        'market_price',
        'stock_num',
        'spec_array'
    ];
}
