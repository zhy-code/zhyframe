<?php

/**
 * 网站后台路由 -- 后台菜单设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/menu/menulist', 'Admin\MenuController@menuList');

	Route::get('/menu/menuadd', 'Admin\MenuController@menuAdd');
	Route::post('/menu/menuaddsave', 'Admin\MenuController@toMenuAdd');

	Route::get('/menu/menuedit/{menuid}', 'Admin\MenuController@menuEdit');
	Route::post('/menu/menueditsave/{menuid}', 'Admin\MenuController@toMenuEdit');

	Route::get('/menu/menustatus/{menuid}/{status?}', 'Admin\MenuController@toMenuStatus');

	Route::delete('/menu/destroy', 'Admin\MenuController@toMenuDestroy');
});

