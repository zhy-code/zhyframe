<?php

namespace App\Http\Controllers\Admin\Goods;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use App\Model\Spec;

class SpecController extends Controller
{
	/*
	 * 列表
	 */
	public function index($id) {
		$result = Spec::with('goodsclass')->paginate(10);
		return View::make('admin.goods.spec_index', ['data' => $result]);
	}


	/*
	 * 新增
	 */
	public function create($id) {
		return View::make('admin.goods.spec_create');
	}
	

	/*
	 * 修改
	 */
	public function edit($id, $sp_id) {
		$result = Spec::with('goodsclass')->where(array('sp_id' => $sp_id))->first();
		return View::make('admin.goods.spec_edit', ['data'=>$result]);
	}


	/*
	 * 删除
	 */
	public function destroy(Request $request) {
		$result = Spec::destroy($request->get('id'));
		$state = $result ? 200 : 0;
        return response()->json(['state' => $state]);
	}


	/*
	 * 存储
	 */
	public function store(Request $request) {
		$data = $request->except('_token');
        $rules = [
            'sp_name' => 'required',
            'sp_sort' => 'integer'
        ];
        $errorMessages = [
            'sp_name.required' => '品牌名称不能为空',
            'sp_sort.integer' => '排序必须是整数'
        ];
        $this->validate($request , $rules , $errorMessages);
		$result = Spec::insert($data);
		if ($result) {
			return Redirect::to('admin/spec/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
	}


	/*
	 * 显示
	 */
	public function show($id) {
		return View::make('admin.goods.spec_show');
	}


	/*
	 * 更新
	 */
	public function update(Request $request, $id) {
		$data = $request->except(['_token' ,'_method']);
        $rules = [
            'sp_name' => 'required',
            'sp_sort' => 'integer'
        ];
        $errorMessages = [
            'sp_name.required' => '品牌名称不能为空',
            'sp_sort.integer' => '排序必须是整数'
        ];
        $this->validate($request , $rules , $errorMessages);

		$result = Spec::where('sp_id', $id)->update($data);
		if ($result) {
			return Redirect::to('admin/spec/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
	}
}