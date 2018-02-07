<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;
use Illuminate\Notifications\Notifiable;

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
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Merchandise $merchandise
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem deleteByIds($ids)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderItem onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem search($where)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem currentStore()
 * @property int|null $order_id 订单id
 * @property string|null $order_code
 * @property string|null $store_code
 * @property string|null $merchandise_code
 * @property string|null $product_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereMerchandiseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereOrderCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereStoreCode($value)
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem searchBy($where)
 * @property-read \App\Models\Store $store
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Refund $refund
 * @property-read \App\Models\Product|null $product
 * @method static bool|null forceDelete()
 * @property int|null $closed
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItem whereClosed($value)
 */
class OrderItem extends Model
{
    use ModelTrait,
        StoreTrait,
        SoftDeletes,
        Notifiable;
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
        'COMPLETED' => '交易完成',
        'REFUND_APPLYING' => '退款申请中',
        'REFUND_PASS'     => '退款申请通过',
        'REFUND_REFUSED'  => '拒绝退款申请',
        'REFUND_CLOSED'   => '退款申请关闭'
    ];

    /**
     * 退款状态字典
     * */
    const REFUND_STATUS = [
        'REFUND_APPLYING' => 'REFUNDING',
        'REFUND_PASS'     => 'REFUNDED',
        'REFUND_REFUSED'  => 'REFUSED',
        'REFUND_CLOSED'   => 'CLOSED'
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
        'code',
        'store_id',
        'store_code',
        'buyer_user_id',
        'order_id',
        'order_code',
        'product_id',
        'product_code',
        'closed',
        'name',
        'sku_properties_name',
        'merchandise_code',
        'merchandise_id',
        'price',
        'post_fee',
        'num',
        'merchandise_main_image_url',
        'total_fee',
        'cancel',
        'status',
        'deleted_at',
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
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function (OrderItem $orderItem){
            $orderItem->code = uniqueCode();
        });
    }

    public function merchandise() : BelongsTo
    {
        return $this->belongsTo(Merchandise::class,'merchandise_id','id');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    public function refund() : HasOne
    {
        return $this->hasOne('App\Models\Refund', 'order_item_id', 'id');
    }


    public function user() :BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'buyer_user_id', 'id');
    }

    public function store() : BelongsTo
    {
        return $this->belongsTo('App\Models\Store', 'buyer_user_id', 'id');
    }

    public  function backStockNum()
    {
        if($this->product){
            $product = $this->product;
            if($product){
                $product->stock_num += $this->num;
                $product->save();
            }
        }

        $merchandise = $this->merchandise;
        if($merchandise){
            $merchandise->stock_num += $this->num;
            $merchandise->save();
        }
    }

}
