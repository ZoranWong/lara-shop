<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;

class OrderItem extends Model
{
    use ModelTrait ,StoreTrait,SoftDeletes;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'order_item';

    const ORDER_WAITPAY  = 'WAIT';
    const ORDER_WAITSEND = 'PAID';
    const ORDER_WAITRECEIVE = 'SEND';
    const ORDER_COMPLETE = 'COMPLETED';
    const ORDER_REFUND = 'REFUND';
    const ORDER_CANCEL = 'CANCEL';

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

    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class,'merchandise_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

}
