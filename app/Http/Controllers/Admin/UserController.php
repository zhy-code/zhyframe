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
	 * 后台管理员编辑页面
	 */
	public function userEdit($userid)
	{
		$user_info = AdminUser::find($userid)->toArray();
		return View::make('admin.user.userview', ['userlist'=>$user_info]);
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
	public function toUserDestroy($userid)
	{
		$user = AdminUser::find($userid);
		dd($user);
		$re = $user->delete();
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