<?php

/**
 * 网站后台路由登陆
 */
Route::get('/admin/login', 'Admin\IndexController@login');
Route::post('/admin/login', 'Admin\IndexController@toLogin');

/**
 * 网站后台首页面框架 后台欢迎页
 */
Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/', 'Admin\IndexController@index');
	Route::get('/welcome', 'Admin\IndexController@welcome');
    
	//退出登录
    Route::get('/logout','Admin\IndexController@logout');

    //后台网站信息管理
    Route::get('/index/webinfo', 'Admin\IndexController@webInfo');
    Route::post('/index/webinfo', 'Admin\IndexController@toWebInfo');
});

