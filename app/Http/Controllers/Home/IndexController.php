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
use App\Model\Joinus;

class IndexController extends BaseController
{
	/**
	 * 首页
	 */
	public function index()
	{
		//获取 banner 图集
		$banner = $this->getBanner('1');
		
		//新闻数据
		$newslist = News::where('status',1)->orderBy('edit_time','desc')->take(3)->get();
		return View::make('home.index.index', ['commoninfo' => $this->common_info, 'banner'=>$banner, 'newslist'=>$newslist]);
	}
	
	/**
	 * 联系我们
	 */
	public function contant()
	{
		//获取 banner 图集
		$banner = $this->getBanner('9');
		$contant['map'] = $this->getBanner('10');
		$contant['address'] = $this->getBanner('11');
		
		//数据
		
		return View::make('home.index.contant', ['commoninfo' => $this->common_info, 'banner'=>$banner,'contant'=>$contant]);
	}
	
	/**
	 * 提交反馈
	 */
	public function feedback(Requests\FeedbackRequest $request){
		
		$data = $request->except(['_token','_method','s']);
		
		$data['add_time'] = time();
		$data['add_ip'] = $request->getClientIp();
		$re = DB::table('feedback')->insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '提交成功',
        	];
		} else {
			$jsonData = [
	            'status'  => '0',
	            'message' => '提交失败',
	        ];
		}
		return response()->json($jsonData);
	} 
}