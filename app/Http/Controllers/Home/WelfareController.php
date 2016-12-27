<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Home\BaseController;

use View;
use DB;
use Session;
use Redirect;

use App\Model\Welfare;

class WelfareController extends BaseController
{
	/**
	 * 公益列表
	 */
	public function index($classify)
	{
		//获取 banner 图集
		$banner = $this->getBanner('8');
		//公益数据
		$welfarelist = Welfare::where('classify',$classify)->where('status',1)->orderBy('edit_time','desc')->get();
		return View::make('home.welfare.index', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'welfarelist'=>$welfarelist, 'classify'=>$classify]);
	}
	
	/**
	 * 公益详情
	 */
	public function details($id)
	{
		//公益数据
		$welfare = Welfare::where('id',$id)->first();
		return View::make('home.welfare.details', ['commoninfo' => $this->common_info, 'welfare'=>$welfare]);
	}
	
	
	/**
	 * 公益首页
	 */
	public function welfareView()
	{
		//获取 banner 图集
		$banner = $this->getBanner('7');
		//公益数据
		$welfare_company = Welfare::where('classify',1)->orderBy('edit_time','desc')->get();
		$welfare_person = Welfare::where('classify',2)->orderBy('edit_time','desc')->take(2)->get();
		return View::make('home.welfare.welfareview', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'welfare_company'=>$welfare_company, 'welfare_person'=>$welfare_person]);
	}
	
}