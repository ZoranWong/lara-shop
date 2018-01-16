<?php
$this->get('logout', 'Auth\LoginController@logout')->name('logout');
Route::auth();