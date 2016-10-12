<?php

namespace App\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;

class BaseController extends Controller
{
	/*
	 * 列表
	 */
	public function index($id) {
		return View::make('admin.setting.menu_index');
	}


	/*
	 * 新增
	 */
	public function create($id) {
		return View::make('admin.setting.menu_create');
	}


	/*
	 * 存储
	 */
	public function store(Request $request) {
		return View::make('admin.setting.menu_store');
	}


	/*
	 * 显示
	 */
	public function show($id) {
		return View::make('admin.setting.menu_show');
	}


	/*
	 * 修改
	 */
	public function edit($id) {
		return View::make('admin.setting.menu_edit');
	}


	/*
	 * 更新
	 */
	public function update(Request $request, $id) {
		return View::make('admin.setting.menu_update');
	}


	/*
	 * 删除
	 */
	public function destroy($id) {
		return View::make('admin.setting.menu_destroy');
	}


	/*
	 * 站点设置
	 */
	public function base($id) {
		return View::make('admin.setting.base_base');
	}


	/*
	 * 防灌水设置
	 */
	public function dump($id) {
		return View::make('admin.setting.base_dump');
	}



}