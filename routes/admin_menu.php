<?php

/**
 * 网站后台路由 -- 后台菜单设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/menu/menulist', 'Admin\menuController@menuList');

	Route::get('/menu/menuadd', 'Admin\menuController@menuAdd');
	Route::post('/menu/menuaddsave', 'Admin\menuController@menuAddSave');

	Route::get('/menu/menuedit/{menuid}', 'Admin\menuController@menuEdit');
	Route::post('/menu/menueditsave/{menuid}', 'Admin\menuController@menuEditSave');

	Route::get('/menu/menustatus/{menuid}/{status?}', 'Admin\menuController@tomenuStatus');

	Route::delete('/menu/destroy', 'Admin\menuController@tomenuDestroy');
});

