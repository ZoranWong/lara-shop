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
    Route::get('/', 'Home\HomeController@index');
    Route::resource('roles', 'Role\RoleController');
    Route::resource('permissions', 'Permission\PermissionController');
    Route::resource('menus', 'Menu\MenuController');
    Route::get('/setting', 'Setting\SettingController@index');
    Route::post('user/avatar', 'FileController@userAvatar');
    Route::resource('orders', 'Order\OrderController');
    Route::get('categories', function (){
      return view('manager.category.index',[]);
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


    //商品分类
  Route::get('category/list', 'CategoryController@index');
  Route::post('category/create', 'CategoryController@store');
  Route::get('category/{id}', 'CategoryController@show');
  Route::post('category/save/{id}', 'CategoryController@update');
  Route::post('category/delete', 'CategoryController@destroy');
});
