<?php

/**
 * 网站后台路由登陆
 */
Route::get('/admin/login', 'Admin\IndexController@login');
Route::post('/admin/login', 'Admin\IndexController@toLogin');

//编辑器文件上传
Route::post('/editor-uploads', 'Admin\OtherController@toUploads');

/**
 * 网站后台首页面框架 后台欢迎页
 */
Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/', 'Admin\IndexController@index');
	Route::get('/welcome', 'Admin\IndexController@welcome');
    
	//退出登录
    Route::get('/logout','Admin\IndexController@logout');

    //后台网站信息管理
    Route::get('/index/siteinfo', 'Admin\IndexController@siteInfo');
    Route::post('/index/siteinfo', 'Admin\IndexController@toSiteInfo');
});

