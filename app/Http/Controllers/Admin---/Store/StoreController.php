<?php

namespace App\Http\Controllers\Admin\Store;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use DB;
use App\Model\Store;
use App\Model\Users;

class StoreController extends Controller
{
	/*
	 * 列表
	 */
	public function index(Request $request, $id) {
		$model = Store::with('users')->orderBy('store_id', 'desc');
		if ($request->get('name')) {
			$model->where('name', 'LIKE', '%'.$request->get('name').'%');	
		}
		$result = $model->paginate(10);
		return View::make('admin.store.store_index', ['data' => $result]);
	}


	/*
	 * 新增
	 */
	public function create($id) {
		return View::make('admin.store.store_create');
	}


	/*
	 * 修改
	 */
	public function edit($id, $store_id) {
		$result = Store::where(array('store_id' => $store_id))->first();
		return View::make('admin.store.store_edit', ['data'=>$result]);
	}


	/*
	 * 更新
	 */
	public function update(Request $request, $id) {
		$data['name'] = $request->get('name');
		$data['status'] = $request->get('status') ? 1 : 0;

		$rules = [
			'name' => 'required'
		];
		$errorMessages = [
			'name.required' => '商铺名称不能为空'
		];
		$this->validate($request , $rules , $errorMessages);

		$store = Store::where('name' , $data['name'])->first();

		if (count($store) > 0 and $store->store_id != $id)
		{
			return Redirect::back()->withErrors('该商铺名称已存在');
		}

		$result = Store::where('store_id', $id)->update($data);
		if ($result !== false) {
			return Redirect::to('admin/store/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
	}

	/*
	 * 删除
	 */
	public function destroy(Request $request) {
		$userId = Store::where(array('store_id' => $request->get('id')))->pluck('user_id');
		if ($userId) {
			DB::beginTransaction();
			$resultStore = Store::destroy($request->get('id'));
			$resultUsers = Users::destroy($userId);
			if ($resultStore && $resultUsers) {
				DB::commit();
				$state = 200;
			} else {
				DB::rollBack();
				$state = 0;
			}
	        return response()->json(['state' => $state]);
		}
	}


	/*
	 * 存储
	 */
	public function store(Request $request) {
		$data = $request->all();

		$this->validate($request, 
			[
            'name' => 'required',
            'mobile' => 'required',
            'password' => 'required|max:20|min:6|confirmed',
            'password_confirmation' => 'required|max:20|min:6',
            ], [
            'required' => ':attribute 不能为空.',
            'max' => ':attribute 长度已经超过设定值.',
            'min' => ':attribute 长度不够.',
            'confirmed' => '两次密码输入不一致.',
            ],[
            'name'   => '店铺名称',
            'mobile'   => '手机号',
            'password' => '登录密码',
            'password_confirmation' => '确认密码',
		]);

		DB::beginTransaction();

		$insertStoreData['name'] = $data['name'];
		$insertStoreData['status'] = $request->get('status') ? 1 : 0;

		$insertUsersData['mobile'] = $data['mobile'];
		$insertUsersData['password'] = bcrypt($data['password']);

		$userId = Users::insertGetId($insertUsersData);
		$insertStoreData['user_id'] = $userId;
		$resultStore = Store::insert($insertStoreData);
		
		if ($resultStore && $userId) {
			DB::commit();
			return Redirect::to('admin/store/index/'.Session::get('menu_id'));
		} else {
			DB::rollBack();
			return Redirect::back();
		}
	}


	/*
	 * 修改密码
	 */
	public function editPass(Request $request) {
		if ($request->get('password') != $request->get('password_confirmation')) {
			return response()->json(['state' => 0, 'info' => '两次密码输入不一致']);
		}

		$users = Users::findOrFail($request->get('user_id'));

		$users->password = bcrypt($request->get('password'));
		$result = $users->save();

		$state = $result !== false ? 200 : 0;
		return response()->json(['state' => $state]);
	}
	
}