<?php

/**
 * 网站后台路由 -- 后台栏目设置 --- 新闻
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	//列表
	Route::get('/welfare/welfarelist', 'Admin\WelfareController@welfareList');
	//新增
	Route::get('/welfare/welfareadd', 'Admin\WelfareController@welfareAdd');
	Route::post('/welfare/welfareaddsave', 'Admin\WelfareController@toWelfareAdd');
	//修改
	Route::get('/welfare/welfareedit/{welfareid}', 'Admin\WelfareController@welfareEdit');
	Route::post('/welfare/welfareeditsave/{welfareid}', 'Admin\WelfareController@toWelfareEdit');
	//状态修改
	Route::get('/welfare/welfarestatus/{welfareid}/{status?}', 'Admin\WelfareController@toWelfareStatus');
	//删除
	Route::delete('/welfare/destroy', 'Admin\WelfareController@toWelfareDestroy');
});

