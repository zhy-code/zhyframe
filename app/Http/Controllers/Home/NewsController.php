<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Home\BaseController;

use View;
use DB;
use Session;
use Redirect;

use App\Model\News;

class NewsController extends BaseController
{
	/**
	 * 新闻列表
	 */
	public function index($classify)
	{
		//获取 banner 图集
		$banner = $this->getBanner('6');
		//新闻数据
		$newslist = News::where('classify',$classify)->where('status',1)->orderBy('edit_time','desc')->get();
		return View::make('home.news.index', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'newslist'=>$newslist, 'classify'=>$classify]);
	}
	
	/**
	 * 新闻详情
	 */
	public function details($id)
	{
		//新闻数据
		$news = News::where('id',$id)->first();
		return View::make('home.news.details', ['commoninfo' => $this->common_info, 'news'=>$news]);
	}
	
	
}