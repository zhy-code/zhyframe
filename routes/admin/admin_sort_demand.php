<?php

/**
 * 网站后台路由 -- 后台需求分类设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/sortdemand/sortdemandlist', 'Admin\SortDemandController@sortdemandList');

	Route::get('/sortdemand/sortdemandadd', 'Admin\SortDemandController@sortdemandAdd');
	Route::post('/sortdemand/sortdemandaddsave', 'Admin\SortDemandController@toSortDemandAdd');

	Route::get('/sortdemand/sortdemandedit/{sortdemandid}', 'Admin\SortDemandController@sortdemandEdit');
	Route::post('/sortdemand/sortdemandeditsave/{sortdemandid}', 'Admin\SortDemandController@toSortDemandEdit');

	Route::get('/sortdemand/sortdemandstatus/{sortdemandid}/{status?}', 'Admin\SortDemandController@toSortDemandStatus');

	Route::delete('/sortdemand/destroy', 'Admin\SortDemandController@toSortDemandDestroy');
});

