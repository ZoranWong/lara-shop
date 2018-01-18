<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([],function(){
    Route::get('/', 'HomeController@index');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('menus', 'MenuController');
    Route::get('orders', function (){
      return view('manager.order.index',['error' => '']);
    });
    Route::get('orders/detail/{id}', function ($id){
      return view('manager.order.detail',['id' => $id]);
    });
});


//ajax请求路由
Route::group(['prefix' => 'ajax','namespace' => 'Ajax'],function(){
  //订单列表
  Route::get('orders/index', 'OrderController@index');
  //修改订单
  Route::post('orders/update/{id}', 'OrderController@update');
  //订单发货
  Route::post('orders/consign/{id}', 'OrderController@consign');
  //删除订单
  Route::post('orders/delete', 'OrderController@destroy');
  //取消订单
  Route::post('orders/cancel', 'OrderController@cancel');
  //订单详情
  Route::get('orders/detail/{id}', 'OrderController@detail');
});
