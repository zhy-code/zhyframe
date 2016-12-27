<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Home\BaseController;

use View;
use DB;
use Session;
use Redirect;

use App\Model\Joinus;

class JoinusController extends BaseController
{
	/**
	 * 加入我们列表
	 */
	public function index()
	{
		//获取 banner 图集
		$banner = $this->getBanner('12');
		//加入我们数据
		$joinuslist = Joinus::where('status',1)->orderBy('edit_time','desc')->take(3)->get();
		return View::make('home.joinus.index', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'joinuslist'=>$joinuslist]);
	}
	
	/**
	 * 加入我们详情
	 */
	public function details($id)
	{
		//加入我们数据
		$joinus = Joinus::where('id',$id)->first();
		return View::make('home.joinus.details', ['commoninfo' => $this->common_info, 'joinus'=>$joinus]);
	}
	
	
}