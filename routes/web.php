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
    Route::resource('stores', 'Store\StoreController');
    Route::resource('admins', 'Administrator\AdministratorController');
    Route::resource('users', 'User\UserController');
    Route::resource('categories', 'Category\CategoryController');
    Route::resource('merchandises', 'Merchandise\MerchandiseController');
});


//ajax请求路由
Route::group(['prefix' => 'ajax'],function(){
    Route::put('/store/{id}/agree', 'Store\StoreController@agree');
    Route::put('/store/{id}/refuse', 'Store\StoreController@refuse');
});
