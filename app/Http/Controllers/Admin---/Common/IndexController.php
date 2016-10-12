<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;

class IndexController extends Controller
{
	/*
	 * 欢迎页面
	 */
	public function index() {
		return View::make('admin.common.index');
	}


}