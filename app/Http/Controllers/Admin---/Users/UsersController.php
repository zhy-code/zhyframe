<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use DB;
use App\Model\Users;

class UsersController extends Controller
{
	/*
	 * 列表
	 */
	public function index(Request $request, $id) {
		$model = Users::orderBy('id', 'desc');
		if ($request->get('username')) {
			$model->where('username', 'LIKE', '%'.$request->get('username').'%');	
		}
		$result = $model->paginate(10);
		return View::make('admin.users.users_index', ['data' => $result]);
	}


	/*
	 * 修改密码视图
	 */
	public function revisePassword($menuId , $userId) {
		return View::make('admin.users.user_revise_password' , ['userId' => $userId]);
	}


	/*
	 * 用户详情
	 */
	public function detail($menuId, $userId) {
        $user = Users::find($userId);
        return View::make('admin.users.users_detail' , ['user' => $user]);
	}


	/*
	 * 修改密码
	 */
	public function update(Request $request, $id) {
		$data = $request->except(['_token' , '_method' , 'password_confirmation']);
        $rules = [
            'password' => 'required | confirmed',
            'password_confirmation' => 'required'
        ];
        $errorMessage = [
            'password.required' => '密码不能为空',
            'password.confirmed' => '两次密码不一致',
            'password_confirmation.required' => '确认密码不能为空',
        ];
        $this->validate($request , $rules , $errorMessage);
        $data['password'] = bcrypt($request->password);
		$result = Users::where('id', $id)->update($data);
		if ($result) {
			return Redirect::to('admin/users/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
	}

}