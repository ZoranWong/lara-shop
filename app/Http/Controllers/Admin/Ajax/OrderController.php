<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Validation\Rule;
use App\Services\StoreService;
use App\Models\User;
use App\Models\Store;
use Excel;
use Exception;

class OrderController
{
    //订单列表
    public function index(Request $request)
    {
        try{
            $queryParams = $request->all();
            $code = array_get($queryParams,'code',null);
            $startTime = array_get($queryParams,'created_at_start',null);
            $endTime = array_get($queryParams,'created_at_end',null);
            $nickname = array_get($queryParams,'nickname',null);
            $status = array_get($queryParams,'status',null);
            $sort   = array_get($queryParams,'sort','created_at');
            $order  = array_get($queryParams,'order','desc');
            $download  = array_get($queryParams,'load');
            $page  = array_get($queryParams,'page',1);
            $limit = 10;
            $offset = ($page-1) * $limit;
            //$storeId = StoreService::getCurrentID();
            $storeId = 1;
            $modelObj = Order::with(['user'=>function($query){
                $query->select(['id','nickname']);
            },'ordersItem'])->where('store_id', $storeId);
            if( $nickname ) {   //昵称搜索
                $fansId = User::where([
                    ['nickname','like','%'. htmlspecialchars($nickname) . '%'],
                    ['store_id',$storeId],
                ])->pluck('id')->all();

                $modelObj = $modelObj->whereIn('buyer_user_id', $fansId);
            }
            if($startTime){
                $modelObj = $modelObj->where('created_at','>=', $startTime);
            }
            if($endTime){
                $modelObj = $modelObj->where('created_at','<=', $endTime);
            }
            if($code){
                $modelObj = $modelObj->where('code', $code);
            }
            if($status){
                //处理退款中订单
                if($status == 60) {
                    // $modelObj = $modelObj->whereHas('ordersItem.refundApply',function($query) {
                    //         $query->where('status','!=',60)->where('status','!=',70);
                    // });
                }else {
                    $modelObj = $modelObj->where('status', $status);
                }
            }
            $data['currentPage'] = $page;

            $data['totalRecord'] = $modelObj->count();

            $data['pageTotal'] = ceil($modelObj->count()/$limit);
            $idList = $modelObj->pluck('id');
            $data['rows'] = $modelObj->orderBy($sort,$order)->offset($offset)->limit($limit)->get()->map(function($item){
                $item->ordersItem->each(function($value , $key){
                    // $value->refundStatus = 0;
                    // if(!$value->refundApply->isEmpty()) {
                    //     $value->refundStatus = $value->refundApply[0]->status;
                    // }
                    // unset($value->refundApply);
                });
                $item->nickname = !empty($item->user->nickname) ? $item->user->nickname : '-';
                $item->receiver_name = !empty($item->receiver_name) ? $item->receiver_name : '-';
                $item->receiver_mobile = !empty($item->receiver_mobile) ? $item->receiver_mobile : '-';
                $item->post_feeAmount = number_format($item->post_fee/100,2);
                $item->paymentAmount = "¥ " . (number_format(($item->payment)/100,2));

                $item->discountFeeAmount = number_format($item->discount_fee/100, 2);
                $item->paid_at = date('Y-m-d H:i:s',$item->paid_at);
                $item->signed_at = date('Y-m-d H:i:s',$item->completed_at);
                $item->consigned_at = date('Y-m-d H:i:s',$item->send_at);
                if($item->post_type == 20) {
                   $item->distributionMode = '线下';
                }
                if($item->post_type == 10) {
                   $item->distributionMode = $item->post_name;
                }
                switch($item->paid_type)
                {
                    case 'WX_PAY':    $item->paid_type = '微信';break;
                    case 'ALI_PAY':   $item->paid_type = '支付宝';break;
                    case 'UNION_PAY': $item->paid_type = '银联快捷';break;
                    case 'OTHER':    $item->paid_type = '其他';break;
                }

                unset($item->user);
                return $item;
            });
            if($download) {

                $ext[] = [
                '订单号','商品名称','商品数量','商品价格','快递费','优惠金额','支付金额','城市','地区','具体地址','手机号','支付时间','签收时间','发货时间','订单状态','收货人','发送方式','支付方式'
                ];
                $shopOrderModel = OrdersItem::with('orders')->where('store_id',$storeId)->whereIn('order_id',$idList)->select('order_id','name','num','price');

                $shopOrderModel->chunk('1000',function ($items) use (&$ext) {
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
                        $item->orderStatus =  $this->formAtShopOrderStatus($item->orders->status);
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
                Excel::create('小程序商城订单记录'.date('Ymd'),function($excel) use ($ext) {
                    $excel->sheet('score', function($sheet) use ($ext) {
                        $sheet->rows($ext);
                    });
                })->download('xlsx');
            }
            return response()->ajax($data);
        } catch (Exception $e){
            $error = $e->getMessage();
            dd($error);
            return response()->errorAjax($error, $e->getCode());
        }
    }

    //订单详情
    public function detail($id)
    {
        try{
            //$storeId = StoreService::getCurrentID();
            $storeId = 1;
            $data = Order::with(['user' => function($query){
                $query->select(['id','nickname']);
            },'ordersItem'])->where('store_id',$storeId)->where('id',$id)->first();
            if(!$data){
                throw new Exception('订单不存在', 404);
            }
            $data->nickname = '-';
            if($data->user){
                $data->nickname = $data->user->nickname; //买家昵称
                unset($data->user);
            }
            $data->refunded_fee = 0;
            if($data->ordersItem){
                foreach ($data->ordersItem as $key => $value) {
                    // if(!$value->refundApply->isEmpty()) {
                    //     $data->refunded_fee += ($value->refundApply->first()->status == 60 ? $value->refundApply->first()->money : 0);
                    // }
                    $data->ordersItem[$key]->priceAmount = "¥ " . number_format($value->price/100, 2);
                    $data->ordersItem[$key]->totalFeeAmount = "¥ " . number_format($value->total_fee/100, 2);
                }
            }
            $data->refunded_fee = number_format($data->refunded_fee / 100 ,2);
            $data->signed_at = !empty($data->send_at) ? date('Y-m-d H:i:s',$data->send_at) : "-";
            $data->paid_at = !empty($data->paid_at) ? date('Y-m-d H:i:s',$data->paid_at) : "-";
            $data->consigned_at = !empty($data->completed_at) ? date('Y-m-d H:i:s',$data->completed_at) : "-";
            if($data->receiver_city) {
                $data->receiver_detail_address = $data->receiver_city . $data->receiver_district . $data->receiver_address;
            } else {
                $data->receiver_detail_address = '还没有填写收获地址';
            }
            $data->post_name = ($data->post_type == 10) ? $data->post_name : (($data->post_type == 20) ? '无物流' : '还未发货');

            $data->postFeeAmount = "¥ " . number_format($data->post_fee/100, 2);
            $data->paymentAmount = "¥ " . number_format($data->payment/100, 2);
            // //是否使用优惠劵
            // $data->useCoupon = 0;
            // if($data->userCoupon){
            //     $data->useCoupon = 1;
            //     // 优惠劵名称
            //     $data->coupon_name = $data->userCoupon->name;
            //     // 满额立减
            //     $data->at_least = 0;
            //     if($data->userCoupon->at_least){
            //         $data->at_least = $data->userCoupon->at_least/100;
            //     }
            //     // 优惠劵面值
            //     $data->value = $data->userCoupon->value/100;
            //     // 优惠金额
            //     $data->discountFeeAmount = number_format($data->discount_fee/100, 2) . "元";
            //     unset($data->userCoupon);
            // }
            return response()->ajax($data);
        } catch (Exception $e){
            $error = $e->getMessage();
            return response()->errorAjax($error, $e->getCode());
        }

    }

    //更新订单
    public function update(Request $request,$id)
    {
        $data = $request->all();
        $response = Order::updateForStore($id,$data);
        return response()->ajax($data);
    }

    //订单发货
    public function consign(Request $request,$id)
    {
        $fileds = [
            'post_type' => 'required|integer'
        ];
        $this->validate($request, $fileds);
        $storeId = StoreService::getCurrentID();
        $orderItemIds = OrdersItem::where('order_id',$id)->get()->pluck('id');
        $applys = \App\Models\Shop\RefundApply::whereIn('order_item_id',$orderItemIds)->where(function($query) {
            $query->orWhere('status','!=',60)->orWhere('status','!=',70);
        })->get()->each(function($item , $key) {
            if($item->status == 10) {
                $item->status = 70;
                $item->save();
                $item->apply_id = $item->id;
                $item->operator = 1;
                unset($item->created_at,$item->updated_at);
                \App\Models\Shop\RefundApplyHistory::create($item->toArray());
            }else {
                return response()->errorAjax('存在不可撤销维权');
            }
        });
        $postType = $request->input('post_type');
        $postNo = $request->input('post_no');
        $postName = $request->input('post_name');
        OrdersItem::where(['store_id'=>$storeId,'order_id'=>$id])
            ->update(['status'=>OrdersItem::ORDER_WAITRECEIVE]);
        $order = Order::where('id',$id)->where(['store_id'=>$storeId,'status'=>Order::ORDER_WAITSEND])->first();
        if(!$order) {
            return response()->errorAjax('订单不存在',404);
        }
        $order->post_name = $postName;
        $order->post_type = $postType;
        $order->post_no = $postNo;
        $order->status = Order::ORDER_WAITRECEIVE;
        $order->consigned_at = time();
        $order->save();
        $order->consigned_at = date('Y-m-d H:i:s',$order->consigned_at);
        //订单发货通知任务
        dispatch((new \App\Jobs\WeappGoodsSendNotice($order->toArray()))->onQueue('default'));

        return response()->ajax($order);
    }
    //关闭订单
    public function cancel(Request $request)
    {
        $fileds = [
            'id' => 'required',
            'id.*' => 'integer',
        ];
        $this->validate($request, $fileds);
        $ids = $request->input('id');
        $storeId = StoreService::getCurrentID();
        OrdersItem::where(['store_id'=>$storeId,'order_id'=>$ids])
            ->update(['status'=>OrdersItem::ORDER_CANCEL]);
        $order = Order::where('id',$ids)->where(['store_id'=>$storeId,'status'=>Order::ORDER_WAITPAY])->first();
        if(!$order) {
            return response()->errorAjax('买家已付款，关闭失败', 400);
        }
        $order->cancel(2);
        return response()->ajax($order);
    }

    //删除订单
    public function destroy(Request $request)
    {
        $fileds = [
            'id' => 'required|array',
            'id.*' => 'integer',
        ];
        $this->validate($request, $fileds);
        $ids = $request->input('id');
        $response = Order::deleteForStoreByIds($ids);
        return response()->ajax($response);
    }

    public function formAtShopOrderStatus($status)
    {
        $map= [];
        $map[Order::ORDER_WAITPAY]      = '待付款';
        $map[Order::ORDER_WAITSEND]     = '待发货';
        $map[Order::ORDER_WAITRECEIVE]  = '待收货';
        $map[Order::ORDER_COMPLETE]     = '已完成';
        $map[Order::ORDER_CANCEL]       = '已关闭';
        return isset($map[$status]) ? $map[$status] : '';
    }
}
