<?php

/**
 * 网站后台路由登陆
 * 
 */
Route::get('/admin/login', 'Admin\Index\IndexController@login');
Route::post('/admin/login', 'Admin\Index\IndexController@toLogin');

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/', 'Admin\Index\IndexController@index');
	Route::get('/welcome', 'Admin\Index\IndexController@welcome');
    
	//退出登录
    Route::get('/logout','Admin\Index\IndexController@logout');
});

