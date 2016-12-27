<?php

/**
 * 网站后台路由 -- 后台栏目设置 --- 集团旗下
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	//列表
	Route::get('/cgroup/cgrouplist', 'Admin\CgroupController@cgroupList');
	//新增
	Route::get('/cgroup/cgroupadd', 'Admin\CgroupController@cgroupAdd');
	Route::post('/cgroup/cgroupaddsave', 'Admin\CgroupController@toCgroupAdd');
	//修改
	Route::get('/cgroup/cgroupedit/{cgroupid}', 'Admin\CgroupController@cgroupEdit');
	Route::post('/cgroup/cgroupeditsave/{cgroupid}', 'Admin\CgroupController@toCgroupEdit');
	//状态修改
	Route::get('/cgroup/cgroupstatus/{cgroupid}/{status?}', 'Admin\CgroupController@toCgroupStatus');
	//删除
	Route::delete('/cgroup/destroy', 'Admin\CgroupController@toCgroupDestroy');
});

