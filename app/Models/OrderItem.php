<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;

/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property string $code 订单编码
 * @property int $store_id 店铺ID
 * @property int $buyer_user_id 购买者用户id
 * @property string $name 商品标题作为此标题的值
 * @property int $merchandise_id 商品ID
 * @property int $product_id 规格产品ID
 * @property string $merchandise_main_image_url 商品主图片缩略图地址
 * @property string $sku_properties_name SKU的值，即：商品的规格 例如：颜色:黑色;尺码:XL;材料:毛绒XL
 * @property float $total_fee 总价
 * @property float $price 价格
 * @property int $num 购买数量
 * @property string $status 支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款
 * @property string $cancel 取消人：BUYER 买家取消 SELLER 卖家取消 AUTO 自动取消
 * @property string $refund 退款 {refund_no:退款编码, total_fee: 订单总金额, refund_fee:退款金额}
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Merchandise $merchandise
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem deleteByIds($ids)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderItem onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem search($where)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem store()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem updateById($id, $data)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereBuyerUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereCancel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereMerchandiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereMerchandiseMainImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereSkuPropertiesName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereTotalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderItem withoutTrashed()
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    use ModelTrait,
        StoreTrait,
        SoftDeletes;
    /**
     * 支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成
     * */
    const STATUS = [
        'WAIT' => 'WAIT',
        'CANCEL' => 'CANCEL',
        'PAID' => 'PAID',
        'SEND' => 'SEND',
        'COMPLETED' => 'COMPLETED'
    ];

    const STATUS_ZH_CN = [
        'WAIT' => '待支付',
        'CANCEL' => '取消订单',
        'PAID' => '待发货',
        'SEND' => '待收货',
        'COMPLETED' => '交易完成'
    ];

    /**
     * 取消人：BUYER 买家取消 SELLER 卖家取消 AUTO 自动取消
     * */
    const CANCEL_TYPE = [
        'BUYER',
        'SELLER',
        'AUTO'
    ];

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'order_item';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code','store_id','buyer_user_id','order_id','product_id',
        'name','sku_properties_name','merchandise_code','merchandise_id',
        'price','num','merchandise_main_image_url','total_fee','price','cancel',
        'refund','status','deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class,'merchandise_id','id');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

}
