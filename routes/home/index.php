<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//首页
Route::get('/', 'Home\IndexController@index');

//意见反馈
Route::post('/feedback', 'Home\IndexController@feedback');

//关于我们
Route::get('/aboutus', 'Home\AboutController@aboutus');
Route::get('/aboutus-dsz', 'Home\AboutController@aboutDsz');
Route::get('/aboutus-strategy', 'Home\AboutController@aboutStrategy');
Route::get('/aboutus-business', 'Home\AboutController@aboutBusiness');

//联系我们
Route::get('/contant', 'Home\IndexController@contant');

//新闻信息
Route::get('/news/{classify}', 'Home\NewsController@index');
Route::get('/newsdetails/{id}', 'Home\NewsController@details');

//社会责任
Route::get('/welfareview', 'Home\WelfareController@welfareView');
Route::get('/welfare/{classify}', 'Home\WelfareController@index');
Route::get('/welfaredetails/{id}', 'Home\WelfareController@details');

//加入我们
Route::get('/joinus', 'Home\JoinusController@index');
Route::get('/joinusdetails/{id}', 'Home\JoinusController@details');

//旗下公司
Route::get('/cgrouplist', 'Home\CgroupController@index');
Route::get('/cgroup/{id}', 'Home\CgroupController@introduce');
Route::get('/cgroupdetails/{id}/{index?}', 'Home\CgroupController@details');
