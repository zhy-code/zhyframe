<?php

/**
 * 网站后台路由 -- 后台服务分类设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/sortservice/sortservicelist', 'Admin\SortServiceController@sortserviceList');

	Route::get('/sortservice/sortserviceadd', 'Admin\SortServiceController@sortserviceAdd');
	Route::post('/sortservice/sortserviceaddsave', 'Admin\SortServiceController@toSortServiceAdd');

	Route::get('/sortservice/sortserviceedit/{sortserviceid}', 'Admin\SortServiceController@sortserviceEdit');
	Route::post('/sortservice/sortserviceeditsave/{sortserviceid}', 'Admin\SortServiceController@toSortServiceEdit');

	Route::get('/sortservice/sortservicestatus/{sortserviceid}/{status?}', 'Admin\SortServiceController@toSortServiceStatus');

	Route::delete('/sortservice/destroy', 'Admin\SortServiceController@toSortServiceDestroy');
});

