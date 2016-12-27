<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\Joinus;

class JoinusController extends Controller
{

	/**
	 * 后台新闻列表
	 */
	public function joinusList()
	{
		$joinus_list = Joinus::orderBy('edit_time','asc')->get();
        $joinus_list_json = json_encode($joinus_list);
		return View::make('admin.joinus.joinuslist', ['joinuslist'=>$joinus_list_json]);
	}
	
	/**
	 * 后台新闻添加页面
	 */
	public function joinusAdd()
	{
		return View::make('admin.joinus.joinusadd');
	}
	
	/**
	 * 后台新闻添加保存
	 */
	public function toJoinusAdd(Requests\JoinusRequest $request)
	{
		$data = $request->except(['_token','_method','s']);

		$data['status'] = 1;
		$data['add_time'] = time();
		$data['edit_time'] = time();
		$re = Joinus::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/joinus/joinuslist',
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
	public function joinusEdit($joinusid)
	{
		$joinus_info = Joinus::find($joinusid);
		return View::make('admin.joinus.joinusedit', ['joinusinfo'=>$joinus_info]);
	}
	
	/**
	 * 后台新闻编辑保存
	 */
	public function toJoinusEdit(Requests\JoinusRequest $request, $joinusid)
	{
		$data = $request->except(['_token','_method','s']);
        
		$data['edit_time'] = time();
		
		$re = Joinus::where('id',$joinusid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/joinus/joinuslist',
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
	public function toJoinusStatus($joinusid, $status=0)
	{
		$joinus_info = Joinus::find($joinusid);
		$joinus_info->status = $status;
		$re = $joinus_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/joinus/joinuslist',
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
	public function toJoinusDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = Joinus::destroy($ids);
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