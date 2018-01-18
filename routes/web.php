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
    Route::get('orders', function (){
      return view('manager.order.index',['error' => '']);
    });
    Route::get('orders/index', 'OrderController@index');
});
