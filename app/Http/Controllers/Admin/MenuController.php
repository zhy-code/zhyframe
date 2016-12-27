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
		$menu_parents = AdminMenu::where('menu_parent_id',0)->orderBy('menu_sort','asc')->get();
        $menulist = $this->getMenuStr($menu_parents);
        $menu_list_json = json_encode($menulist);
        //dd($menu_list_json);
		return View::make('admin.menu.menulist', ['menulist'=>$menu_list_json]);
	}
	
	protected function getMenuStr($menulist){
		if(count($menulist)){
			foreach ($menulist as $k => $menu){
				$info[$k]['text'] = $menu->menu_name;
				
				$del    = "<i class='fa fa-trash-o' onclick=\"layListDel(this,'/admin/menu/destroy','".$menu->menu_id."','reload')\"></i>";
				if($menu->menu_status){
					$updown = "<i class='fa fa-level-down' onclick=\"layChangeStatus('/admin/menu/menustatus/".$menu->menu_id."/0','隐藏')\"></i>";
				}else{
					$updown = "<i class='fa fa-level-up' onclick=\"layChangeStatus('/admin/menu/menustatus/".$menu->menu_id."/1','显示')\"></i>";
				}
				$edit   = "<i class='fa fa-edit' onclick=\"layOpenView('/admin/menu/menuedit/".$menu->menu_id."','90%','90%','菜单编辑')\"></i>";
				
				$info[$k]['tags'] = [$del,$updown,$edit];
				
				$childlist = AdminMenu::where('menu_parent_id', $menu->menu_id)->orderBy('menu_sort','asc')->get();
				$info[$k]['nodes'] = $this->getMenuStr($childlist);
			}
		}else{
			$info = '';
		}
		return $info;
	}
	
	/**
	 * 后台菜单添加页面
	 */
	public function menuAdd()
	{
		$menulist = AdminMenu::where('menu_parent_id',0)->orderBy('menu_sort','asc')->get();
		return View::make('admin.menu.menuadd',['menulist'=>$menulist]);
	}
	
	/**
	 * 后台菜单添加保存
	 */
	public function toMenuAdd(Requests\AdminMenuRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		$data['menu_status'] = 1;
		$data['menu_add_time'] = time();
		$data['menu_add_ip'] = $request->getClientIp();
		$data['menu_creator'] = Session::get('adminuser')['user_id'];
		$re = AdminMenu::insert($data);
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
		$menu_info = AdminMenu::find($menuid);
		$menulist = AdminMenu::where('menu_parent_id',0)->orderBy('menu_sort','asc')->get();
		return View::make('admin.menu.menuedit', ['menuinfo'=>$menu_info,'menulist'=>$menulist]);
	}
	
	/**
	 * 后台菜单编辑保存
	 */
	public function toMenuEdit(Requests\AdminMenuRequest $request, $menuid)
	{
		$data = $request->except(['_token','_method','s']);
		$re = AdminMenu::where('menu_id',$menuid)->update($data);
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
	public function toMenuStatus($menuid, $status=0)
	{
		$menu_info = AdminMenu::find($menuid);
		$menu_info->menu_status = $status;
		$re = $menu_info->save();
		if ($re) {
			//链式操作
			AdminMenu::where('menu_parent_id',$menuid)->update(['menu_status'=>$status]);
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
	public function toMenuDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = AdminMenu::destroy($ids);
		if ($re) {
			//链式操作
			AdminMenu::whereIn('menu_parent_id',$ids)->delete();
			
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