<?php

/**
 * 网站后台路由 -- 后台商铺分类设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/sortgoodsshop/sortgoodsshoplist', 'Admin\SortGoodsShopController@sortgoodsshopList');

	Route::get('/sortgoodsshop/sortgoodsshopadd', 'Admin\SortGoodsShopController@sortgoodsshopAdd');
	Route::post('/sortgoodsshop/sortgoodsshopaddsave', 'Admin\SortGoodsShopController@toSortGoodsShopAdd');

	Route::get('/sortgoodsshop/sortgoodsshopedit/{sortgoodsshopid}', 'Admin\SortGoodsShopController@sortgoodsshopEdit');
	Route::post('/sortgoodsshop/sortgoodsshopeditsave/{sortgoodsshopid}', 'Admin\SortGoodsShopController@toSortGoodsShopEdit');

	Route::get('/sortgoodsshop/sortgoodsshopstatus/{sortgoodsshopid}/{status?}', 'Admin\SortGoodsShopController@toSortGoodsShopStatus');

	Route::delete('/sortgoodsshop/destroy', 'Admin\SortGoodsShopController@toSortGoodsShopDestroy');
});

