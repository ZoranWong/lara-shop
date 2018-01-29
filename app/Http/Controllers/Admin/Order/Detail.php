<?php
namespace App\Http\Controllers\Admin\Order;


use App\Models\Order;

class Detail
{
    protected $view = "store.order.form.detail";

    /**
     * @var Order
     * */
    protected $order = null;

    public function __construct($order = null)
    {
        $this->order = $order;
    }

    public function render()
    {
        foreach ($this->order->orderItems as &$item){
            $item['price'] = sprintf('%.2f', $item['price']);
            $item['total_fee'] = sprintf('%.2f', $item['total_fee']);
        }
        $this->tip($this->order);
        return view($this->view, [
            'order' => $this->order ? $this->order : null,
            'order_json' => $this->order ? [$this->order] : '{}',
        ])->render();
    }

    protected function tip(&$order)
    {
        if($order && $order->post_type){
            $order->post_type = Order::POST_TYPE[$order['post_type']];
        }
        if($order){
            $order['status_str'] = Order::STATUS_ZH_CN[$order['status']];
            switch ($order['status']){
                case Order::STATUS['WAIT']:{
                    $order['step'] = 1;
                    $order['tip'] = "请务必等待订单状态变更为“等待商家发货”后再进行发货。";
                    break;
                }
                case Order::STATUS['PAID']:{
                    $order['step'] = 2;
                    $order['tip'] = "请及时给用户发货，如有问题请联系用户协商处理";
                    break;
                }
                case Order::STATUS['SEND']:{
                    $order['step'] = 3;
                    $order['tip'] = "请及时关注你发出的包裹状态，确保能配送至买家手中；\n-如果买家表示未收到货或者货物有问题，请及时联系买家积极处理，友好协商；";
                    $order['post'] = '&nbsp;&nbsp;&nbsp;运单号: &nbsp;&nbsp;&nbsp;'.$order['post_no'];
                    break;
                }
                case Order::STATUS['COMPLETED']:{
                    $order['tip'] = "交易完成，如果买家提出售后要求，请积极自行于买家协商，做好售后服务。";
                    $order['step'] = 4;
                    $order['post'] = '&nbsp;&nbsp;&nbsp;运单号: &nbsp;&nbsp;&nbsp;'.$order['post_no'];
                    break;
                }
                default:
                    $order['step'] = 0;
                    break;
            }
        }
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->render();
    }
}