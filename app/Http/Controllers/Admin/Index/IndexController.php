<?php

namespace App\Http\Controllers\Admin\Index;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;

class IndexController extends Controller
{
	/**
	 * 后台控制主架构
	 */
	public function index() {
		return View::make('admin.index.index');
	}

	/**
	 * 后台控制主页面
	 */
	public function welcome() {
		return View::make('admin.index.welcome');
	}

	
	/**
     *  后台退出操作
     */
    public function logout(){
        $res = Session::forget('user');
        return Redirect::to('/admin/login');
    }
}