<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', function (){
    return response()->api('api version 1.0.0');
});
Route::post('/user/login', 'WechatAuthController@userLogin');
Route::post('/store/login', 'WechatAuthController@storeOwnerLogin');
Route::group(['prefix' =>'user'], function (\Illuminate\Routing\Router $router){
    $router->get('/', function (Request $request){
        return Response::ajax('request');
    });

    $router->get('/orders','User\OrderController@list');
//
    $router->get('/order/{id}', 'User\OrderController@detail');

    $router->post('/order', 'User\OrderController@create');

    $router->post('/order/refund', 'User\RefundController@apply');

    $router->put('/order/refund/{id}/close', 'User\RefundController@close');

    $router->put('/order/sign/{orderId}', 'User\OrderController@sign');

    $router->get('/order/{orderId}/pay', 'User\PaymentController@pay');

    $router->post('/order/{orderId}/pay/notify', 'User\PaymentController@notify');
//
    $router->get('/merchandises', 'User\MerchandiseController@list');
//
    $router->get('/merchandise/{id}', 'User\MerchandiseController@detail');

    $router->get('/shopping/cart', 'User\ShoppingCartController@list');
    $router->post('/shopping/cart', 'User\ShoppingCartController@add');
    $router->put('/shopping/cart/{id}/add/{num}', 'User\ShoppingCartController@setNum');
    $router->delete('/shopping/carts/{ids}', 'User\ShoppingCartController@remove');

    $router->post('/distribution/apply', 'User\DistributionController@apply');
    $router->get('/distribution/subordinate', 'User\DistributionController@subordinate');
    $router->get('/distribution/subordinate/num', 'User\DistributionController@subordinateSetting');
    $router->get('/distribution/info', 'User\DistributionController@info');
    $router->post('/distribution/cash/extract', 'User\DistributionCashController@extract');
    $router->get('/distribution/cash/extract/history', 'User\DistributionCashController@extractHistory');
    $router->get('/distribution/orders/commission/list', 'User\DistributionCashController@detailListMe');
    $router->get('/distribution/cash/detail', 'User\DistributionCashController@detail');
    $router->get('/distribution/extract/setting/show', 'User\DistributionCashController@extractSettingShow');
    $router->get('/distribution/order/list', 'User\DistributionOrderController@orderListDetail');
});

Route::group(['prefix' => 'store'], function (\Illuminate\Routing\Router $router){
    $router->get('/', function (Request $request){
        $request->user();
        return Response::ajax('store');
    });

//    $router->get('/store/orders', '');
//
//    $router->get('/store/merchandises', '');
//
//    $router->get('/store/merchandise/{$id}', '');
//
//    $router->get('/store/order/{id}', '');
//
//    $router->get('/store/group/coupons', '');
//
//    $router->get('/store/group/coupon/{id}', '');
//
//    $router->get('/store/group/coupons/orders', '');
//
//    $router->get('/store/group/coupons/order/{id}', '');
});
