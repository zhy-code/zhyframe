<?php

/**
 * 网站后台路由登陆
 * 
 */
Route::get('/admin/login', 'Admin\IndexController@login');
Route::post('/admin/login', 'Admin\IndexController@toLogin');

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/', 'Admin\IndexController@index');
	Route::get('/welcome', 'Admin\IndexController@welcome');
    
	//退出登录
    Route::get('/logout','Admin\IndexController@logout');
});

