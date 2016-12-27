<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Home\BaseController;

use View;
use DB;
use Session;
use Redirect;

use App\Model\Cgroup;

class CgroupController extends BaseController
{
	/**
	 * 子企业列表
	 */
	public function index()
	{
		//获取 banner 图集
		$banner = $this->getBanner('8');
		//子企业数据
		$cgrouplist = Cgroup::where('classify',1)->where('status',1)->orderBy('edit_time','desc')->get();
		return View::make('home.cgroup.index', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'cgrouplist'=>$cgrouplist]);
	}
	
	/**
	 * 子企业介绍
	 */
	public function introduce($id)
	{
		//子企业数据
		$cgroup = Cgroup::where('id',$id)->first();
		switch($id){
			case 1:
				$view = 'qipan';
				break;
			case 2:
				$view = 'chengqi';
				break;
			case 3:
				$view = 'xier';
				break;
			case 5:
				$view = 'hanguang';
				break;
			case 6:
				$view = 'zhongyi';
				break;
			default:
				$view = 'qipan';
				break;				
		}
		return View::make('home.cgroup.list_'.$view, ['commoninfo' => $this->common_info, 'cgroup'=>$cgroup]);
	}
	
	/**
	 * 子企业详情
	 */
	public function details($id,$index='')
	{
		//子企业数据
		$cgroup = Cgroup::where('id',$id)->first();
		switch($id){
			case 1:
				$view = 'qipan';
				break;
			case 2:
				$view = 'chengqi';
				break;
			case 3:
				$view = 'xier';
				break;
			case 5:
				$view = 'hanguang';
				break;
			case 6:
				$view = 'zhongyi';
				break;
			default:
				$view = 'qipan';
				break;				
		}
		if($id==1){
			$view = $view.'_'.$index;
		}
		return View::make('home.cgroup.details_'.$view, ['commoninfo' => $this->common_info, 'cgroup'=>$cgroup]);
	}
	
}