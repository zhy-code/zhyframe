<?php

/**
 * 网站后台路由--管理员
 * 10470c3b4b1fed12c3baac014be15fac67c6e815
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/user/userlist', 'Admin\UserController@userList');

	Route::get('/user/useredit/{userid}', 'Admin\UserController@userEdit');
	Route::get('/user/userstatus/{userid}/{status?}', 'Admin\UserController@toUserStatus');
});

