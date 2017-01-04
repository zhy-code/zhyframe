<?php

/**
 * 网站后台路由--商品商铺管理
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/goodsshop/goodsshoplist', 'Admin\GoodsShopController@goodsshopList');

	Route::get('/goodsshop/goodsshopedit/{goodsshopid}', 'Admin\GoodsShopController@goodsshopEdit');
	Route::post('/goodsshop/goodsshopeditsave/{goodsshopid}', 'Admin\GoodsShopController@toGoodsShopEdit');
	
	Route::get('/goodsshop/details/{goodsshopid}', 'Admin\GoodsShopController@goodsshopDetails');
	
	Route::get('/goodsshop/goodsshopstatus/{goodsshopid}/{status?}', 'Admin\GoodsShopController@toGoodsShopStatus');

	Route::delete('/goodsshop/destroy', 'Admin\GoodsShopController@toGoodsShopDestroy');
});

