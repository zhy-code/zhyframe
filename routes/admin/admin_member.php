<?php

/**
 * 网站后台路由--会员管理
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/member/memberlist', 'Admin\MemberController@memberList');

	Route::get('/member/memberedit/{memberid}', 'Admin\MemberController@memberEdit');
	Route::post('/member/membereditsave/{memberid}', 'Admin\MemberController@toMemberEdit');

	Route::get('/member/memberstatus/{memberid}/{status?}', 'Admin\MemberController@toMemberStatus');

	Route::delete('/member/destroy', 'Admin\MemberController@toMemberDestroy');
});

