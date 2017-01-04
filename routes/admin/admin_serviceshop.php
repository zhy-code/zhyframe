<?php

/**
 * 网站后台路由--商品商铺管理
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/serviceshop/serviceshoplist', 'Admin\ServiceShopController@serviceshopList');

	Route::get('/serviceshop/serviceshopedit/{serviceshopid}', 'Admin\ServiceShopController@serviceshopEdit');
	Route::post('/serviceshop/serviceshopeditsave/{serviceshopid}', 'Admin\ServiceShopController@toServiceShopEdit');
	
	Route::get('/serviceshop/details/{serviceshopid}', 'Admin\ServiceShopController@serviceshopDetails');
	
	Route::get('/serviceshop/serviceshopstatus/{serviceshopid}/{status?}', 'Admin\ServiceShopController@toServiceShopStatus');

	Route::delete('/serviceshop/destroy', 'Admin\ServiceShopController@toServiceShopDestroy');
});

