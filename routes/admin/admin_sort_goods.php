<?php

/**
 * 网站后台路由 -- 后台商品分类设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/sortgoods/sortgoodslist', 'Admin\SortGoodsController@sortgoodsList');

	Route::get('/sortgoods/sortgoodsadd', 'Admin\SortGoodsController@sortgoodsAdd');
	Route::post('/sortgoods/sortgoodsaddsave', 'Admin\SortGoodsController@toSortGoodsAdd');

	Route::get('/sortgoods/sortgoodsedit/{sortgoodsid}', 'Admin\SortGoodsController@sortgoodsEdit');
	Route::post('/sortgoods/sortgoodseditsave/{sortgoodsid}', 'Admin\SortGoodsController@toSortGoodsEdit');

	Route::get('/sortgoods/sortgoodsstatus/{sortgoodsid}/{status?}', 'Admin\SortGoodsController@toSortGoodsStatus');

	Route::delete('/sortgoods/destroy', 'Admin\SortGoodsController@toSortGoodsDestroy');
});

