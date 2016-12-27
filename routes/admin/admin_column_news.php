<?php

/**
 * 网站后台路由 -- 后台栏目设置 --- 新闻
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	//列表
	Route::get('/news/newslist', 'Admin\NewsController@newsList');
	//新增
	Route::get('/news/newsadd', 'Admin\NewsController@newsAdd');
	Route::post('/news/newsaddsave', 'Admin\NewsController@toNewsAdd');
	//修改
	Route::get('/news/newsedit/{newsid}', 'Admin\NewsController@newsEdit');
	Route::post('/news/newseditsave/{newsid}', 'Admin\NewsController@toNewsEdit');
	//状态修改
	Route::get('/news/newsstatus/{newsid}/{status?}', 'Admin\NewsController@toNewsStatus');
	//删除
	Route::delete('/news/destroy', 'Admin\NewsController@toNewsDestroy');
});

