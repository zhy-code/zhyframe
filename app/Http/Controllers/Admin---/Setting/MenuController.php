<?php

namespace App\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Menu;
use Redirect;
use Session;

use View;

class MenuController extends Controller
{
	/*
	 * 列表
	 */
	public function index(Request $request , $id) {
	    $query = Menu::orderBy('id' , 'desc');
        if ($request->has('name'))
        {
            $query = $query->where('name' , 'like' , '%'.$request->name.'%');
        }
        $menus = $query->paginate(10);
		return View::make('admin.setting.menu_index' , ['menus' => $menus]);
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
	public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $data['status'] = isset($data['status']) ? $data['status'] : 0;
        $data['listorder'] = $request->has('listorder') ? $data['listorder'] : 0;
        $rules = [
            'name' => 'required',
            'app' => 'required',
            'group' => 'required',
            'model' => 'required',
            'action' => 'required',
            'listorder' => 'integer'
        ];
        $errorMessage = [
            'name.required' => '名称不能为空',
            'app.required' => '应用名称不能为空',
            'group.required' => '分组名称不能为空',
            'model.required' => '控制器不能为空',
            'action.required' => '操作名称不能为空',
            'listorder.integer' => '排序必须为整数'
        ];
        $this->validate($request, $rules, $errorMessage);
        $result = Menu::insert($data);
        if ($result) {
            return Redirect::to('admin/menu/index/' . Session::get('menu_id'));
        } else {
            return Redirect::back();
        }
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
	public function edit($id , $menu_id) {
	    $menu = Menu::find($menu_id);
		return View::make('admin.setting.menu_edit' , ['menu' => $menu]);
	}


	/*
	 * 更新
	 */
	public function update(Request $request, $id) {
        $data = $request->except(['_token' , '_method']);
        $data['status'] = isset($data['status']) ? $data['status'] : 0;
        $rules = [
            'name' => 'required',
            'app' => 'required',
            'group' => 'required',
            'model' => 'required',
            'action'=> 'required',
            'listorder' => 'integer'
        ];
        $errorMessage = [
            'name.required' => '名称不能为空',
            'app.required' => '应用名称不能为空',
            'group.required' => '分组名称不能为空',
            'model.required' => '控制器不能为空',
            'action.required' => '操作名称不能为空',
            'listorder.integer' => '排序必须为整数'
        ];
        $this->validate($request , $rules , $errorMessage);
        $menu = Menu::where('name' , $data['name'])->first();
        if (count($menu) > 0 and $menu->id != $id)
        {
            return Redirect::back()->withErrors('菜单已存在');
        }
        $result = Menu::where('id', $id)->update($data);
        if ($result) {
            return Redirect::to('admin/menu/index/'.Session::get('menu_id'));
        } else {
            return Redirect::back();
        }
	}


	/*
	 * 删除
	 */
	public function destroy(Request $request) {
        $result = Menu::destroy($request->get('id'));
        $state = $result ? 200 : 0;
        return response()->json(['state' => $state]);
	}



}