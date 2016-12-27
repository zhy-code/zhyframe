<?php

/**
 * 网站后台路由--Banner 图管理
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/banner/bannerlist/{classify?}', 'Admin\BannerController@bannerList');

	Route::get('/banner/banneradd', 'Admin\BannerController@bannerAdd');
	Route::post('/banner/banneraddsave', 'Admin\BannerController@tobannerAdd');

	Route::get('/banner/banneredit/{bannerid}', 'Admin\BannerController@bannerEdit');
	Route::post('/banner/bannereditsave/{bannerid}', 'Admin\BannerController@tobannerEdit');
});

