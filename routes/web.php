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
    Route::resource('orders', 'Order\OrderController');
    Route::resource('stores', 'Store\StoreController');
    Route::resource('admins', 'Administrator\AdministratorController');
    Route::resource('users', 'User\UserController');
    Route::resource('categories', 'Category\CategoryController');
    Route::resource('merchandises', 'Merchandise\MerchandiseController');
    Route::resource('group/coupons', 'GroupCoupon\GroupCouponController');
});


//ajax请求路由
Route::group(['prefix' => 'ajax'],function(){
    Route::put('/store/{id}/agree', 'Store\StoreController@agree');
    Route::put('/store/{id}/refuse', 'Store\StoreController@refuse');
    Route::get('/specification', 'Merchandise\SpecificationController@index');
    Route::post('/specification', 'Merchandise\SpecificationController@store');
    Route::put('/specification/{id}', 'Merchandise\SpecificationController@update');
    Route::post('/editor/upload/image', 'FileController@serve');
    Route::post('/user/avatar', 'FileController@userAvatar');
    Route::post('/merchandise/image', 'FileController@merchandiseImage');
    Route::post('/merchandise', 'Merchandise\MerchandiseController@ajaxStore');
    Route::put('/merchandise/{id}', 'Merchandise\MerchandiseController@ajaxUpdate');
    Route::get('/merchandise/{merchandiseId}/products', 'Merchandise\MerchandiseController@products');
    Route::put('/merchandise/on/{ids}', 'Merchandise\MerchandiseController@onShelves');
    Route::put('/merchandise/off/{ids}', 'Merchandise\MerchandiseController@takenOff');
    Route::get('/merchandises', 'Merchandise\MerchandiseController@ajaxList');
    Route::put('/order/{id}/send/merchandise', 'Order\OrderController@sendMerchandise');
    Route::put('/refund/{id}/agree', 'Refund\RefundController@agree');
    Route::put('/refund/{id}/refuse', 'Refund\RefundController@refuse');
    Route::post('/group/coupon/save', 'GroupCoupon\GroupCouponController@ajaxStore');
});
