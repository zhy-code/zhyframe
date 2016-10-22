<?php

namespace App\Http\Controllers\Admin\Index;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AdminMenu;
use View;

class IndexController extends Controller
{
	/**
	 * 后台控制主架构
	 */
	public function index()
	{
		$menulist = AdminMenu::where(['menu_parent_id' => 0, 'menu_status' => 1])->get()->toArray();
		if ($menulist) {
			foreach ($menulist as $key => $value) {
				$menulist[$key]['soninfo'] = AdminMenu::where(['menu_parent_id' => $value['menu_id'], 'menu_status' => 1])->get()->toArray();
			}
		}
		return View::make('admin.index.index', ['menulist' => $menulist]);
	}

	/**
	 * 后台控制主页面
	 */
	public function welcome()
	{
		return View::make('admin.index.welcome');
	}

	/**
	 * 后台控制主页面
	 */
	public function login()
	{
		return View::make('admin.index.login');
	}

	
	/**
     *  后台退出操作
     */
    public function logout()
    {
        $res = Session::forget('user');
        return Redirect::to('/admin/login');
    }
}