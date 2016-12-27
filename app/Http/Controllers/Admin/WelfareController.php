<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\Welfare;

class WelfareController extends Controller
{

	/**
	 * 后台新闻列表
	 */
	public function welfareList()
	{
		$welfare_list = Welfare::orderBy('edit_time','asc')->get();
        $welfare_list_json = json_encode($welfare_list);
		return View::make('admin.welfare.welfarelist', ['welfarelist'=>$welfare_list_json]);
	}
	
	/**
	 * 后台新闻添加页面
	 */
	public function welfareAdd()
	{
		return View::make('admin.welfare.welfareadd');
	}
	
	/**
	 * 后台新闻添加保存
	 */
	public function toWelfareAdd(Requests\WelfareRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		
		//Base64 保存图片
		$fileroot = 'uploads/images/'.date("Ymd").'/';
		$data['title_pic'] = $this->basePic($data['title_pic'],$fileroot);
		
		$data['status'] = 1;
		$data['add_time'] = time();
		$data['edit_time'] = time();
		$re = Welfare::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/welfare/welfarelist',
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
	public function welfareEdit($welfareid)
	{
		$welfare_info = Welfare::find($welfareid);
		return View::make('admin.welfare.welfareedit', ['welfareinfo'=>$welfare_info]);
	}
	
	/**
	 * 后台新闻编辑保存
	 */
	public function toWelfareEdit(Requests\WelfareRequest $request, $welfareid)
	{
		$data = $request->except(['_token','_method','s']);
		
		//Base64 保存图片
		$fileroot = 'uploads/images/'.date("Ymd");
		$data['title_pic'] = $this->basePic($data['title_pic'],$fileroot);
		
		$data['edit_time'] = time();
		
		$re = Welfare::where('id',$welfareid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/welfare/welfarelist',
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
	public function toWelfareStatus($welfareid, $status=0)
	{
		$welfare_info = Welfare::find($welfareid);
		$welfare_info->status = $status;
		$re = $welfare_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/welfare/welfarelist',
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
	public function toWelfareDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = Welfare::destroy($ids);
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