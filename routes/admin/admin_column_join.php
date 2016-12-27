<?php

/**
 * 网站后台路由 -- 后台栏目设置 --- 新闻
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	//列表
	Route::get('/joinus/joinuslist', 'Admin\JoinusController@joinusList');
	//新增
	Route::get('/joinus/joinusadd', 'Admin\JoinusController@joinusAdd');
	Route::post('/joinus/joinusaddsave', 'Admin\JoinusController@toJoinusAdd');
	//修改
	Route::get('/joinus/joinusedit/{joinusid}', 'Admin\JoinusController@joinusEdit');
	Route::post('/joinus/joinuseditsave/{joinusid}', 'Admin\JoinusController@toJoinusEdit');
	//状态修改
	Route::get('/joinus/joinusstatus/{joinusid}/{status?}', 'Admin\JoinusController@toJoinusStatus');
	//删除
	Route::delete('/joinus/destroy', 'Admin\JoinusController@toJoinusDestroy');
});

