<?php
namespace App\Http\Controllers\Admin\Order\Services;

use App\Models\OrderItem;
use App\Services\StoreService;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class OrdersExport{
    protected static $exportFields =[
        '订单号','商品名称','商品数量','商品价格','快递费','优惠金额','支付金额','城市','地区','具体地址',
        '手机号','支付时间','签收时间','发货时间','订单状态','收货人','发送方式','支付方式'
    ];
    public static function download(array  $ordersIdList){
        $storeId = StoreService::getCurrentID();
        $shopOrderModel = OrderItem::with('orders')->where('store_id',$storeId)->whereIn('order_id',$ordersIdList)
            ->select('order_id','name','num','price');
        $shopOrderModel->chunk('1000',function ($items)  {
            foreach($items as $item){
                // 订单号
                $item->order_no = $item['orders']['order_no'];
                // 商品价格
                $item->priceAmount = number_format($item->price/100, 2);
                // 快递费
                $item->post_fee = number_format($item->orders->post_fee/100, 2);
                // 优惠金额
                $item->discount_fee = number_format($item->orders->discount_fee/100, 2);
                // 支付金额
                $item->payment = number_format($item->orders->payment/100, 2);
                // 城市
                $item->receiver_city = $item->orders->receiver_city;
                // 地区
                $item->receiver_district = $item->orders->receiver_district;
                // 具体地址
                $item->receiver_address = $item->orders->receiver_address;
                // 手机号
                $item->receiver_mobile = $item->orders->receiver_mobile;
                // 支付时间
                $item->paid_at = $item->orders->paid_at ? date('Y-m-d H:i:s', $item->orders->paid_at) : '';
                // 签收时间
                $item->signed_at = $item->orders->signed_at ? date('Y-m-d H:i:s', $item->orders->signed_at) : '';
                // 发货时间
                $item->consigned_at = $item->orders->consigned_at ? date('Y-m-d H:i:s', $item->orders->consigned_at) : '';
                // 订单状态
                //$item->orderStatus =  $this->formAtShopOrderStatus($item->orders->status);
                // 收货人
                $item->receiver_name = $item->orders->receiver_name;
                // 发送方式
                if($item->orders->post_type == 20) {
                    $item->distributionMode = '线下';
                }
                // 支付方式
                if($item->orders->post_type == 10) {
                    $item->distributionMode = $item->orders->post_name;
                }
                switch($item->orders->paid_type)
                {
                    case 'wxpay':    $item->paid_type = '微信';break;
                    case 'alipay':   $item->paid_type = '支付宝';break;
                    case 'unionpay': $item->paid_type = '银联快捷';break;
                    case 'other':    $item->paid_type = '其他';break;
                }

                $ext[] = [
                    $item->order_no,
                    $item->name,
                    $item->num,
                    $item->priceAmount,
                    $item->post_fee,
                    $item->discount_fee,
                    $item->payment,
                    $item->receiver_city,
                    $item->receiver_district,
                    $item->receiver_address,
                    $item->receiver_mobile,
                    $item->paid_at,
                    $item->signed_at,
                    $item->consigned_at,
                    $item->orderStatus,
                    $item->receiver_name,
                    $item->distributionMode,
                    $item->paid_type
                ];
            }
        });
        Excel::create('小程序商城订单记录'.date('Ymd'),function(LaravelExcelWriter $excel)  {
            $excel->sheet('score', function(LaravelExcelWorksheet $sheet)  {
                $sheet->rows(static::$exportFields);
            });
        })->download('xlsx');
    }
}