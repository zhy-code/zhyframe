<?php

namespace App\Http\Controllers\Admin\Goods;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Redirect;
use Config;
use Session;
use App\Model\GoodsClass;

class GoodsClassController extends Controller
{
	/*
	 * 列表
	 */
	public function index($id) {
		$result = GoodsClass::with('type')->where(array('gc_parent_id' => 0))->get();
		return View::make('admin.goods.goodsclass_index', ['data'=>$result]);
	}


	/*
	 * 新增
	 */
	public function create($id) {
		return View::make('admin.goods.goodsclass_create');
	}


	/*
	 * 新增子分类
	 */
	public function createSon($id, $class_id) {
		return View::make('admin.goods.goodsclass_create', ['class_id' => $class_id]);
	}


	/*
	 * 修改
	 */
	public function edit($id, $class_id) {
		$result = GoodsClass::with('type')->where(array('gc_id' => $class_id))->first();
		return View::make('admin.goods.goodsclass_edit', ['data'=>$result]);
	}


	/*
	 * 删除
	 */
	public function destroy(Request $request) {
		$result = GoodsClass::destroy($request->get('id'));
		$state = $result ? 200 : 0;
        return response()->json(['state' => $state]);
	}


	/*
	 * 存储
	 */
	public function store(Request $request) {
		$data = $request->all();
		$data['recommend'] = 1;
		unset( $data['_token'] );

		// 上传图片
		$data['image'] = $this->updateImage($request->file("image"));
		$rules = [
			'gc_name' => 'required',
			'gc_sort' => 'integer'
		];
		$errorMessages = [
			'gc_name.required' => '分类名称不能为空',
			'gc_sort.integer' => '排序必须是整数'
		];
		$this->validate($request , $rules , $errorMessages);

		$result = GoodsClass::insert($data);
		if ($result) {
			return Redirect::to('admin/goodsclass/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
	}


	/*
	 * 更新
	 */
	public function update(Request $request, $id) {
		$data = $request->except(['_token' , '_method']);
		// 上传图片
		$data['image'] = $this->updateImage($request->file("image"));
		$rules = [
			'gc_name' => 'required',
			'gc_sort' => 'integer'
		];
		$errorMessages = [
			'gc_name.required' => '分类名称不能为空',
			'gc_sort.integer' => '排序必须是整数'
		];
		$this->validate($request , $rules , $errorMessages);

		$result = GoodsClass::where('gc_id', $id)->update($data);
		if ($result) {
			return Redirect::to('admin/goodsclass/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
	}


	/**
	 * ajax 获取子分类
	 */
	public function ajaxson(Request $request) {
		$result = GoodsClass::with('type')->where(array('gc_parent_id' => $request->get('id')))->get();
		$state = count($result) > 0 ? 200 : 0;
		return response()->json(['data' => $result, 'state' => $state]);
	}

	/**
	 * 上传品牌图片
	 */
	private function updateImage($file) {
		if ( $file && $file->isValid() ) {
			$extension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $newName = md5(date('ymdhis').uniqid()) . '.' . $extension;
            $file->move(Config::get('cloudsystem.UPLOAD_GOODS_CLASS'), $newName);
            return $newName;
		} else {
			return '';
		}
	}

}