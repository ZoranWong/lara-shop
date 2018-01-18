<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\StoreTrait;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Merchandise;
use App\Models\Product;
use DB;

class Order extends Model
{
    use ModelTrait ,StoreTrait , SoftDeletes;

    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'order';
    /**
     * 支付状态：WAIT 待支付 CANCEL 取消 PAID 完成支付 SEND 发货 COMPLETED  签收或者完成 REFUND 退款
     * */
    const STATUS = [
        'WAIT' => 'WAIT',
        'CANCEL' => 'CANCEL',
        'PAID' => 'PAID',
        'SEND' => 'SEND',
        'COMPLETED' => 'COMPLETED',
        'REFUND' => 'REFUND'
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
     *订单完成：BUYER 买家确认 SELLER 卖家确认 AUTO 自动确认
     * */
    const COMPLETE_TYPE = [
        'BUYER',
        'SELLER',
        'AUTO'
    ];
    const ORDER_WAITPAY  = 'WAIT';
    const ORDER_WAITSEND = 'PAID';
    const ORDER_WAITRECEIVE = 'SEND';
    const ORDER_COMPLETE = 'COMPLETED';
    const ORDER_REFUND = 'REFUND';
    const ORDER_CANCEL = 'CANCEL';
    const POST_ONLINE = 10;
    const POST_OFFLINE = 20;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code','store_id','buyer_user_id','num',
        'payment_fee','total_fee',
        'status','cancel','complete','pay_type','paid_at','completed_at','send_at','refund','deleted_at'
    ];

    protected $columns = [
      'id','code','store_id','buyer_user_id','num',
      'payment_fee','total_fee',
      'status','cancel','complete','pay_type','paid_at','completed_at','send_at','refund',
      'created_at','update_at','deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function ordersItem()
    {
      return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function user()
    {
      return $this->belongsTo('App\Models\User','buyer_user_id');
    }

    public function cancel($cancel='BUYER')
    {
      $order = $this;
      $order->status = self::ORDER_CANCEL;
      $order->cancel = $cancel;//取消人
      $order->save();
      $this->backStockNum($order->id);
      //event(new \App\Events\WeappShop\OrderCancel($order));
      return  $order;
    }


    public static function backStockNum($orderId)
    {
        if(!is_array($orderId))$orderId = [$orderId];
        $orderGoods = OrderItem::whereIn('order_id',$orderId)->get();
        if($orderGoods){
            foreach($orderGoods as $v){
                if($v['product_id'] > 0){
                    $product = Product::find($v['product_id']);
                    if($product){
                        $product->stock_num += $v['num'];
                        $product->save();
                    }
                }
                $goods = Merchandise::find($v['merchandise_id']);
                if($goods){
                    $goods->stock_num += $v['num'];
                    $goods->save();
                }
            }
        }
        return true;
    }

    public function expressQuery()
    {
        $postid = $this->post_no; //'117082212900994501';
        $type    = array_search($this->post_name, config('params.express',[])); //'rufengda';
        if($postid && $type && $type != 'other') {
            $kd100Api = "https://m.kuaidi100.com/query?type={$type}&postid={$postid}";
            $expressResult = curl_get_data($kd100Api);
            $expressArray = json_decode($expressResult,true);

            if($expressArray) {
                $data = [];
                /**
                0：在途，即货物处于运输过程中；
                1：揽件，货物已由快递公司揽收并且产生了第一条跟踪信息；
                2：疑难，货物寄送过程出了问题；
                3：签收，收件人已签收；
                4：退签，即货物由于用户拒签、超区等原因退回，而且发件人已经签收；
                5：派件，即快递正在进行同城派件；
                6：退回，货物正处于退回发件人的途中；
                **/
                $stateMap = [];
                $stateMap[0] = '在途，即货物处于运输过程中';
                $stateMap[1] = '揽件，快递员已揽件';
                $stateMap[2] = '疑难，货物寄送过程出了问题';
                $stateMap[3] = '签收，收件人已签收';
                $stateMap[4] = '退签，即货物由于用户拒签、超区等原因退回，而且发件人已经签收';
                $stateMap[5] = '派件，即快递正在进行同城派件';
                $stateMap[6] = '退回，货物正处于退回发件人的途中';
                $data['state'] = array_get($expressArray, 'state', -1);
                $data['state_msg'] = $stateMap[$data['state']];
                $data['data']  = array_get($expressArray, 'data', []);

                return $data;
            }

        }

        return [];
    }

    public static function countDiscoundPayment($discountFee , $orderPayment,$itemPayment,$itemNum,$num,$temPayment)
    {
        if($num > $itemNum) {
            return max(floor($itemPayment - $discountFee * $itemPayment / $orderPayment),0);
        }else {
            return $orderPayment - $discountFee - $temPayment;
        }
    }

    //订单优惠劵
    public function userCoupon()
    {
        return $this->hasOne('App\Models\Shop\CouponUser','id','user_coupon_id');
    }

    //计算最大退款(不含邮费)
    public static function countRefundNoPost($array = [] , $orderPayment , $postFee)
    {
      $payment = array_sum($array);
      $i = 1;
      $total = count($array);
      $discount = $payment - $orderPayment + $postFee;
      $tempPayment = 0;
      foreach ($array as $key => $value) {
            if($orderPayment <= $postFee) {
                $data[$key] = 0;
            }else {
            if($i >= $total) {
              $data[$key] = max($payment - $tempPayment - $discount , 0);
            }else {
              $data[$key] = max(floor($value - $discount * $value / $payment) , 0);
            }
            }
        $i = $i + 1;
        $tempPayment = $data[$key] + $tempPayment;
      }
      return $data;
    }
}
