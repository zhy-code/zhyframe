<?php

/**
 * 网站后台路由 -- 后台菜单设置
 */

Route::group(['middleware'=>'adminAuth', 'prefix' => 'admin'],function() {
	Route::get('/feedback/feedbacklist', 'Admin\FeedbackController@feedbackList');

	Route::post('/feedback/remark', 'Admin\FeedbackController@toFeedbackRemark');

	Route::delete('/feedback/destroy', 'Admin\FeedbackController@tofeedbackDestroy');
});

