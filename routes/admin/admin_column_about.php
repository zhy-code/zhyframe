<?php

/**
 * 网站后台路由 -- 后台栏目设置 --- 新闻
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	//列表
	Route::get('/about/aboutlist', 'Admin\AboutController@aboutList');
	//新增
	Route::get('/about/aboutadd', 'Admin\AboutController@aboutAdd');
	Route::post('/about/aboutaddsave', 'Admin\AboutController@toAboutAdd');
	//修改
	Route::get('/about/aboutedit/{aboutid}', 'Admin\AboutController@aboutEdit');
	Route::post('/about/abouteditsave/{aboutid}', 'Admin\AboutController@toAboutEdit');
	//状态修改
	Route::get('/about/aboutstatus/{aboutid}/{status?}', 'Admin\AboutController@toAboutStatus');
	//删除
	Route::delete('/about/destroy', 'Admin\AboutController@toAboutDestroy');
});

