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
    Route::get('distribution', 'Distribution\DistributionController@index');
    Route::get('distribution/setting', 'Distribution\DistributionController@setting');
    Route::get('distribution/setting/cash', 'Distribution\DistributionController@settingCash');
    Route::get('distribution/setting/commission', 'Distribution\DistributionController@settingCommission');
    Route::get('distribution/cash', 'Distribution\DistributionController@cash');
    Route::get('distribution/member', 'Distribution\DistributionController@member');
    Route::get('distribution/member/apply', 'Distribution\DistributionController@memberApply');
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
    Route::put('/group/coupon/{id}', 'GroupCoupon\GroupCouponController@ajaxUpdate');
    Route::get('/distribution/order/statics', 'Distribution\OrderController@chartDaily');
    Route::post('/distribution/commission/level/edit', 'Distribution\CommissionController@distributionCommissionLevelEdit');
    Route::post('/distribution/commission/level/save', 'Distribution\CommissionController@saveCommissionLevel');
    Route::get('/distribution/commission/level/list', 'Distribution\CommissionController@commissionLevelList');
    Route::post('/distribution/setting/basic', 'Distribution\SettingController@basic');
    Route::get('/distribution/commission/cash/setting', 'Distribution\CashController@setting');
    Route::post('/distribution/commission/cash/setting', 'Distribution\CashController@setting');
    Route::get('/distribution/member/list', 'Distribution\MemberController@membersList');
    Route::get('/distribution/cash/list', 'Distribution\CashController@cashList');
    Route::get('/distribution/level/name/{storeId}', 'Distribution\CommissionController@levels');
});
