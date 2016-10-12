<?php

namespace App\Http\Controllers\Admin\Goods;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use App\Model\Brand;

class BrandController extends Controller
{
	/*
	 * 列表
	 */
	public function index(Request $request ,$id) {
		$model = Brand::with('goodsclass');
		if ($request->get('brand_name')) {
			$model->where('brand_name', 'LIKE', '%'.$request->get('brand_name').'%');	
		}
		$result = $model->paginate(10);
		return View::make('admin.goods.brand_index', ['data' => $result])->withInput($request->all());
	}


	/*
	 * 新增
	 */
	public function create($id) {
		return View::make('admin.goods.brand_create');
	}


	/*
	 * 修改
	 */
	public function edit($id, $brand_id) {
		$result = Brand::with('goodsclass')->where(array('brand_id' => $brand_id))->first();
		return View::make('admin.goods.brand_edit', ['data'=>$result]);
	}


	/*
	 * 删除
	 */
	public function destroy(Request $request) {
		$result = Brand::destroy($request->get('id'));
		$state = $result ? 200 : 0;
        return response()->json(['state' => $state]);
	}


	/*
	 * 存储
	 */
	public function store(Request $request) {
		$data = $request->except('_token');
        $data['brand_recommend'] = $request->brand_recommend ? $request->brand_recommend : 0;

		// 上传图片
		$data['brand_pic'] = $this->updateImage($request->file("brand_pic"));

		$rules = [
			'brand_name' => 'required',
			'brand_initial' => 'required',
			'brand_sort' => 'integer'
		];
		$errorMessages = [
			'brand_name.required' => '品牌名称不能为空',
			'brand_initial.required' => '品牌首字母不能为空',
			'brand_sort.integer' => '排序必须是整数'
		];
		$this->validate($request , $rules , $errorMessages);

		$result = Brand::insert($data);
		if ($result) {
			return Redirect::to('admin/brand/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
	}


	/*
	 * 更新
	 */
	public function update(Request $request, $id) {
		$data = $request->except(['_token' , '_method']);
        $data['brand_recommend'] = $request->brand_recommend ? $request->brand_recommend : 0;

		// 上传图片
		$data['brand_pic'] = $this->updateImage($request->file("brand_pic"));

		$data['brand_recommend'] = $request->get('brand_recommend') ? 1 : 0;
		$rules = [
			'brand_name' => 'required',
			'brand_initial' => 'required',
			'brand_sort' => 'integer'
		];
		$errorMessages = [
			'brand_name.required' => '品牌名称不能为空',
			'brand_initial.required' => '品牌首字母不能为空',
			'brand_sort.integer' => '排序必须是整数'
		];
		$this->validate($request , $rules , $errorMessages);

		$result = Brand::where('brand_id', $id)->update($data);
		if ($result !== false) {
			return Redirect::to('admin/brand/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
	}


	/**
	 * ajax推荐
	 */
	public function ajaxRecommend(Request $request)
	{
		$data['brand_recommend'] = $request->get('state');
		$result = Brand::where(['brand_id' => $request->get('id')])->update($data);
		$state = $result ? 200 : 0;
		return response()->json(['state' => $state]);
	}


	/**
	 * 上传品牌图片
	 */
	private function updateImage($file) {
		if ( $file && $file->isValid() ) {
			$extension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $newName = md5(date('ymdhis').uniqid()) . '.' . $extension;
            $file->move(Config::get('cloudsystem.UPLOAD_BRAND'), $newName);
            return $newName;
		} else {
			return '';
		}
	}

}