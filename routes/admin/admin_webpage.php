<?php

/**
 * 网站后台路由--网站单页
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/user/userlist', 'Admin\UserController@userList');

	Route::get('/user/useradd', 'Admin\UserController@userAdd');
	Route::post('/user/useraddsave', 'Admin\UserController@userAddSave');

	Route::get('/user/useredit/{userid}', 'Admin\UserController@userEdit');
	Route::post('/user/usereditsave/{userid}', 'Admin\UserController@userEditSave');

	Route::get('/user/userstatus/{userid}/{status?}', 'Admin\UserController@toUserStatus');

	Route::delete('/user/destroy', 'Admin\UserController@toUserDestroy');
});

