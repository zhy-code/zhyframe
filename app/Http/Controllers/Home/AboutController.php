<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Home\BaseController;

use View;
use DB;
use Session;
use Redirect;

use App\Model\About;

class AboutController extends BaseController
{
	/**
	 * 关于我们/集团介绍 --- 组织架构
	 */
	public function aboutus()
	{
		//获取 banner 图集
		$banner = $this->getBanner('2');
		
		$aboutus = About::where('id',2)->first();
		$aboutus_chart = About::where('id',3)->first();
		return View::make('home.aboutus.aboutus', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'aboutus'=>$aboutus,'aboutus_chart'=>$aboutus_chart]);
	}
	
	/**
	 * 董事长致辞
	 */
	public function aboutDsz()
	{
		//获取 banner 图集
		$banner = $this->getBanner('3');
		
		$aboutus = About::where('id',1)->first();
		return View::make('home.aboutus.aboutdsz', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'aboutus'=>$aboutus]);
	}
	
	/**
	 * 发展战略
	 */
	public function aboutStrategy()
	{
		//获取 banner 图集
		$banner = $this->getBanner('5');
		
		$aboutus = About::where('id',5)->first();
		return View::make('home.aboutus.aboutstrategy', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'aboutus'=>$aboutus]);
	}
	
	/**
	 * 集团业务
	 */
	public function aboutBusiness()
	{
		//获取 banner 图集
		$banner = $this->getBanner('4');
		
		//新闻数据
		$aboutus = About::where('id',4)->first();
		return View::make('home.aboutus.aboutbusiness', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'aboutus'=>$aboutus]);
	}
	
	
}