<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ShoppingCart
 *
 * @property int $id
 * @property int $store_id 店铺id
 * @property int $store_code 店铺code
 * @property int $buyer_user_id 购买者id
 * @property int $merchandise_id 商品id
 * @property string $merchandise_code 商品code
 * @property int $product_id 规格商品id
 * @property string $product_code 规格商品code
 * @property string $name 商品名称
 * @property string $merchandise_main_image_url 商品图片
 * @property string $sku_properties_name SKU的值，即：商品的规格 例如：颜色:黑色;尺码:XL;材料:毛绒XL
 * @property float $total_fee 总价
 * @property float $price 单价
 * @property int $num 商品数量
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart deleteByIds($ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart searchBy($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereMerchandiseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereMerchandiseMainImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereSkuPropertiesName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereStoreCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereTotalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @property-read \App\Models\Merchandise $merchandise
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Store $store
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShoppingCart onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShoppingCart withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ShoppingCart withoutTrashed()
 * @property string|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShoppingCart whereCode($value)
 */
class ShoppingCart extends Model
{
    //
    use ModelTrait, SoftDeletes;

    protected $table = 'shopping_cart';

    protected $fillable = [
        'name',
        'store_id',
        'store_code',
        'merchandise_id',
        'merchandise_code',
        'buyer_user_id',
        'product_id',
        'product_code',
        'merchandise_main_image_url',
        'sku_properties_name',
        'total_fee',
        'price',
        'num',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (ShoppingCart $shoppingCart){
            $shoppingCart->code = uniqueCode();
        });
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'buyer_user_id', 'id');
    }

    public function store() : BelongsTo
    {
        return $this->belongsTo('App\Models\Store', 'store_id', 'id');
    }

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo('App\Models\Merchandise', 'merchandise_id', 'id');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function buildOrderItem()
    {
        $data = $this->toArray();
        $data['status'] = OrderItem::STATUS['WAIT'];
        return new OrderItem($data);
    }
}
