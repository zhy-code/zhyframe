<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\Cgroup;

class CgroupController extends Controller
{

	/**
	 * 后台旗下公司列表
	 */
	public function cgroupList()
	{
		$cgroup_list = Cgroup::orderBy('edit_time','asc')->get();
        $cgroup_list_json = json_encode($cgroup_list);
		return View::make('admin.cgroup.cgrouplist', ['cgrouplist'=>$cgroup_list_json]);
	}
	
	/**
	 * 后台旗下公司添加页面
	 */
	public function cgroupAdd()
	{
		return View::make('admin.cgroup.cgroupadd');
	}
	
	/**
	 * 后台旗下公司添加保存
	 */
	public function toCgroupAdd(Requests\CgroupRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		
		//Base64 保存图片
		$fileroot = 'uploads/images/'.date("Ymd").'/';
		$data['title_pic'] = $this->basePic($data['title_pic'],$fileroot);
		
		$data['status'] = 1;
		$data['add_time'] = time();
		$data['edit_time'] = time();
		$re = Cgroup::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/cgroup/cgrouplist',
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
	 * 后台旗下公司编辑页面
	 */
	public function cgroupEdit($cgroupid)
	{
		$cgroup_info = Cgroup::find($cgroupid);
		return View::make('admin.cgroup.cgroupedit', ['cgroupinfo'=>$cgroup_info]);
	}
	
	/**
	 * 后台旗下公司编辑保存
	 */
	public function toCgroupEdit(Requests\CgroupRequest $request, $cgroupid)
	{
		$data = $request->except(['_token','_method','s']);
		
		//Base64 保存图片
		$fileroot = 'uploads/images/'.date("Ymd");
		$data['title_pic'] = $this->basePic($data['title_pic'],$fileroot);
		
		$data['edit_time'] = time();
		
		$re = Cgroup::where('id',$cgroupid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/cgroup/cgrouplist',
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
	 * 后台旗下公司变更状态
	 */
	public function toCgroupStatus($cgroupid, $status=0)
	{
		$cgroup_info = Cgroup::find($cgroupid);
		$cgroup_info->status = $status;
		$re = $cgroup_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/cgroup/cgrouplist',
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
	 * 后台旗下公司删除
	 */
	public function toCgroupDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = Cgroup::destroy($ids);
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