<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;
use Illuminate\Database\Query\Builder;
use Exception;
use Illuminate\Support\Collection;

/**
 * App\Models\Merchandise
 *
 * @property int $id
 * @property int $store_id 店铺ID
 * @property int $category_id 分类ID
 * @property string $code 商品编号
 * @property string $name 商品名称
 * @property string $main_image_url 主图url
 * @property float $sell_price 售价
 * @property float $max_price 最大价格
 * @property float $min_price 最小价格
 * @property int $stock_num 库存
 * @property int $sell_num 销售数量
 * @property int $sort 排序
 * @property string $brief_introduction 简介
 * @property string $content 商品详细内容
 * @property array $spec_array JSON存储规格数组,数组元素{name:"XX",id:"XX",value:{"XX":"XX"}}
 * @property string $status 货物状态:ON=上架，UNDER=下架
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise deleteByIds($ids)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Merchandise onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereBriefIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereMainImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereMaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereMinPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise wherePrimePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereSellNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereSpecArray($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereStockNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Merchandise withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Merchandise withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \App\Models\Store $store
 * @property float $prime_price 原价
 * @property float|null $market_price 原价
 * @property array $images
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise currentStore()
 * @method bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Merchandise whereMarketPrice($value)
 */
class Merchandise extends Model
{
    use ModelTrait ,StoreTrait , SoftDeletes;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'merchandise';

    const   STATUS = [
        'TAKEN_OFF'  => 'TAKEN_OFF',//商品下架
        'ON_SHELVES' => 'ON_SHELVES',//商品上架
        'SELL_OUT'   => 'SELL_OUT',//售罄
//        'DELETE'     => 'DELETE',//已删除
    ];

    const   STATUS_ZH_CN = [
        ' '           => '全部',
        'TAKEN_OFF'  => '商品下架',//商品下架
        'ON_SHELVES' => '商品上架',//商品上架
        'SELL_OUT'   => '售罄',//售罄
//        'DELETE'     => '已删除',//已删除
    ];

    protected $casts = [
        'spec_array' => 'array',
        'images' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id','category_id','code','name','main_image_url','sell_price','max_price','images',
        'min_price','stock_num','sell_num','sort','brief_introduction','content','market_price',
        'spec_array','status','deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function store() : BelongsTo
    {
        return $this->belongsTo('App\Models\Store', 'store_id', 'id');
    }

    public function products () : HasMany
    {
        return $this->hasMany('App\Models\Product', 'merchandise_id', 'id');
    }

    public function saveProducts(Collection $products, string $key = 'code')
    {
        $list =  $products->map(function (Product $product) use(&$key){
            $model = Product::where('merchandise_id', $this->id)->where($key, $product[$key])->first();
            if($model){
                $data = $product->toArray();
                unset($data[$key]);
                $model->update($data);
            }else{
                $model = $this->products()->save($product);
            }
            return $model->toArray();
        });

        $this['products'] = $list->toArray();
    }
}
