<?php

/**
 * 网站后台路由 -- 后台商铺分类设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/sortserviceshop/sortserviceshoplist', 'Admin\SortServiceShopController@sortserviceshopList');

	Route::get('/sortserviceshop/sortserviceshopadd', 'Admin\SortServiceShopController@sortserviceshopAdd');
	Route::post('/sortserviceshop/sortserviceshopaddsave', 'Admin\SortServiceShopController@toSortServiceShopAdd');

	Route::get('/sortserviceshop/sortserviceshopedit/{sortserviceshopid}', 'Admin\SortServiceShopController@sortserviceshopEdit');
	Route::post('/sortserviceshop/sortserviceshopeditsave/{sortserviceshopid}', 'Admin\SortServiceShopController@toSortServiceShopEdit');

	Route::get('/sortserviceshop/sortserviceshopstatus/{sortserviceshopid}/{status?}', 'Admin\SortServiceShopController@toSortServiceShopStatus');

	Route::delete('/sortserviceshop/destroy', 'Admin\SortServiceShopController@toSortServiceShopDestroy');
});

