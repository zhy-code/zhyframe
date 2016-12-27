<?php

/**
 * 网站后台路由 -- 后台菜单设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/sort/sortshoplist', 'Admin\sortController@sortShopList');

	Route::get('/sort/sortshopadd', 'Admin\sortController@sortShopAdd');
	Route::post('/sort/sortshopaddsave', 'Admin\sortController@toSortShopAdd');

	Route::get('/sort/sortshopedit/{sortshopid}', 'Admin\sortController@sortShopEdit');
	Route::post('/sort/sortshopeditsave/{sortshopid}', 'Admin\sortController@toSortShopEdit');

	Route::get('/sort/sortshopstatus/{sortid}/{status?}', 'Admin\sortController@toSortShopStatus');

	Route::delete('/sort/shopdestroy', 'Admin\sortController@toSortShopDestroy');
});

