<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\About;

class AboutController extends Controller
{

	/**
	 * 后台新闻列表
	 */
	public function aboutList()
	{
		$about_list = About::orderBy('edit_time','asc')->get();
        $about_list_json = json_encode($about_list);
		return View::make('admin.about.aboutlist', ['aboutlist'=>$about_list_json]);
	}
	
	/**
	 * 后台新闻添加页面
	 */
	public function aboutAdd()
	{
		return View::make('admin.about.aboutadd');
	}
	
	/**
	 * 后台新闻添加保存
	 */
	public function toAboutAdd(Requests\AboutRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		
		$data['status'] = 1;
		$data['add_time'] = time();
		$data['edit_time'] = time();
		$re = About::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/about/aboutlist',
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
	 * 后台新闻编辑页面
	 */
	public function aboutEdit($aboutid)
	{
		$about_info = About::find($aboutid);
		return View::make('admin.about.aboutedit', ['aboutinfo'=>$about_info]);
	}
	
	/**
	 * 后台新闻编辑保存
	 */
	public function toAboutEdit(Requests\AboutRequest $request, $aboutid)
	{
		$data = $request->except(['_token','_method','s']);
		
		$data['edit_time'] = time();
		
		$re = About::where('id',$aboutid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/about/aboutlist',
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
	 * 后台新闻变更状态
	 */
	public function toAboutStatus($aboutid, $status=0)
	{
		$about_info = About::find($aboutid);
		$about_info->status = $status;
		$re = $about_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/about/aboutlist',
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
	 * 后台新闻删除
	 */
	public function toAboutDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = About::destroy($ids);
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