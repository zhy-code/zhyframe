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
		if ($user_list) {
			foreach ($user_list as $key => $value) {
				$user_list[$key]['user_status_format'] = $value['user_status'] ? '正常' : '禁用';
				$user_list[$key]['user_last_login_time_format'] = date("Y-m-d H:i:s", $value['user_last_login_time']);
				$html  = "<i class='fa fa-edit' onclick=layOpenView('/admin/user/useredit/{$value['user_id']}','90%','90%','管理员信息编辑')></i>";
				if ($value['user_status']) {
					$html .= "<i class='fa fa-level-down ml-15' onclick=layChangeStatus('/admin/user/userstatus/{$value['user_id']}/0','禁用')></i>";
				} else {
					$html .= "<i class='fa fa-level-up ml-15' onclick=layChangeStatus('/admin/user/userstatus/{$value['user_id']}/1','启用')></i>";
				}
				$html .= "<i class='fa fa-trash-o ml-15'></i>";
				$user_list[$key]['user_operation'] = $html;
			}
		}
		$user_list_json = json_encode($user_list);
		return View::make('admin.user.userlist', ['userlist'=>$user_list_json]);
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

}