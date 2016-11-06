<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use View;
use Session;
use Redirect;
use App\Model\AdminUser;

class UserController extends Controller
{

	/**
	 * 后台管理员列表
	 */
	public function userList()
	{
		$user_list = AdminUser::get()->toArray();
		$user_list_json = json_encode($user_list);
		return View::make('admin.user.userlist', ['userlist'=>$user_list_json]);
	}
	
	/**
	 * 后台管理员添加页面
	 */
	public function userAdd()
	{
		return View::make('admin.user.useradd');
	}
	
	/**
	 * 后台管理员添加保存
	 */
	public function userAddSave(Requests\AdminUserAddRequest $request)
	{
		dd($data);
		$data = $request->except(['_token','_method']);
		$data['user_status'] = 1;
		$data['user_add_time'] = time();
		$data['user_add_ip'] = $request->getClientIp();
		$data['user_edit_time'] = time();
		$data['user_edit_ip'] = $request->getClientIp();
		$re = AdminUser::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/user/userlist',
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
	 * 后台管理员编辑页面
	 */
	public function userEdit($userid)
	{
		$user_info = AdminUser::find($userid);
		return View::make('admin.user.useredit', ['userinfo'=>$user_info]);
	}
	
	/**
	 * 后台管理员编辑保存
	 */
	public function userEditSave(Requests\AdminUserEditRequest $request, $userid)
	{
		$data = $request->except(['_token','_method']);
		if($request->has('user_password')){
			$data['user_password'] = Hash::make(md5($data['user_password']));
		}
		$data['user_edit_time'] = time();
		$data['user_edit_ip'] = $request->getClientIp();
		$re = AdminUser::where('user_id',$userid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/user/userlist',
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
	 * 后台管理员变更状态
	 */
	public function toUserStatus($userid, $status=0)
	{
		$user_info = AdminUser::find($userid);
		$user_info->user_status = $status;
		$re = $user_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/user/userlist',
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
	 * 后台管理员删除
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