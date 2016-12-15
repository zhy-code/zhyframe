<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use View;
use Session;
use Redirect;
use App\Model\AdminMenu;

class MenuController extends Controller
{

	/**
	 * 后台菜单列表
	 */
	public function menuList()
	{
		$menu_parents = AdminMenu::where('menu_parent_id',0)->get();
        foreach($menu_parents as $key => $menu){
            $tmp[$key]['text'] = $menu->menu_name;
            $tmp[$key]['tags'] = ["<span onclick=alert('汉子')>Edit</span>", "<span onclick=alert('汉子')>Delete</span>"];
            $menu_child = AdminMenu::where('menu_parent_id', $menu->menu_id)->get();
            if(count($menu_child)){
                foreach ($menu_child as $k => $child){
                    $tmp_child[$k]['text'] = $child->menu_name;
                    $tmp_child[$k]['tags'] = ["<span onclick=alert('汉子')>Edit</span>", "<span onclick=alert('汉子')>Delete</span>"];
                }
                $tmp[$key]['nodes'] = $tmp_child;
            }
        }
        $menu_list_json = json_encode($tmp);
        //dd($menu_list_json);
		return View::make('admin.menu.menulist', ['menulist'=>$menu_list_json]);
	}
	
	/**
	 * 后台菜单添加页面
	 */
	public function menuAdd()
	{
		return View::make('admin.menu.menuadd');
	}
	
	/**
	 * 后台菜单添加保存
	 */
	public function menuAddSave(Requests\AdminUserAddRequest $request)
	{
		$data = $request->except(['_token','_method']);
		$data['menu_status'] = 1;
		$data['menu_add_time'] = time();
		$data['menu_add_ip'] = $request->getClientIp();
		$data['menu_edit_time'] = time();
		$data['menu_edit_ip'] = $request->getClientIp();
		$re = AdminUser::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/menu/menulist',
        	];
		} else {
			$jsonData = [
	            'status'  => '0',
	            'message' => '增加失败',
	        ];
		}
		return response()->json($jsonData);
	}
	
	/**
	 * 后台菜单编辑页面
	 */
	public function menuEdit($menuid)
	{
		$menu_info = AdminUser::find($menuid);
		return View::make('admin.menu.menuedit', ['menuinfo'=>$menu_info]);
	}
	
	/**
	 * 后台菜单编辑保存
	 */
	public function menuEditSave(Requests\AdminUserEditRequest $request, $menuid)
	{
		$data = $request->except(['_token','_method']);
		if($request->get('menu_password')){
			$data['menu_password'] = Hash::make(md5($data['menu_password']));
		}
		$data['menu_edit_time'] = time();
		$data['menu_edit_ip'] = $request->getClientIp();
		$re = AdminUser::where('menu_id',$menuid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/menu/menulist',
        	];
		} else {
			$jsonData = [
	            'status'  => '0',
	            'message' => '编辑失败',
	        ];
		}
		return response()->json($jsonData);
	}
	
	/**
	 * 后台菜单变更状态
	 */
	public function toUserStatus($menuid, $status=0)
	{
		$menu_info = AdminUser::find($menuid);
		$menu_info->menu_status = $status;
		$re = $menu_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/menu/menulist',
        	];
		} else {
			$jsonData = [
	            'status'  => '0',
	            'message' => '变更失败',
	        ];
		}
		return response()->json($jsonData);
	}

	/**
	 * 后台菜单删除
	 */
	public function toUserDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = AdminUser::destroy($ids);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '删除成功',
        	];
		} else {
			$jsonData = [
	            'status'  => '0',
	            'message' => '删除失败',
	        ];
		}
		return response()->json($jsonData);
	}

}