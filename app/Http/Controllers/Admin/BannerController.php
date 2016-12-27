<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\Banner;

class BannerController extends Controller
{

	/**
	 * 后台Banner列表
	 */
	public function bannerList($classify = null)
	{
		if($classify){
			$banner_list = Banner::where('banner_classify',$classify)->get();
		}else{
			$banner_list = Banner::get();
		}
		$classifylist = Banner::distinct()->pluck('banner_classify');
		return View::make('admin.banner.bannerlist', ['bannerlist'=>$banner_list,'classifylist'=>$classifylist, 'classify'=>$classify]);
	}
	
	/**
	 * 后台Banner添加页面
	 */
	public function bannerAdd()
	{
		return View::make('admin.banner.banneradd');
	}
	
	/**
	 * 后台Banner添加保存
	 */
	public function toBannerAdd(Request $request)
	{
		$data = $request->except(['_token','_method','s']);
		$data['link_url'] = implode('::::::',$data['link_url']);
		
		//Base64 保存图片
		if(isset($data['banner_url'])){
			$fileroot = 'uploads/images/'.date("Ymd").'/';
			$data['banner_url'] = $this->basePic($data['banner_url'],$fileroot);
		}
		$re = Banner::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/banner/bannerlist',
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
	 * 后台Banner编辑页面
	 */
	public function bannerEdit($bannerid)
	{
		$banner_info = Banner::find($bannerid);
		return View::make('admin.banner.banneredit', ['bannerinfo'=>$banner_info]);
	}
	
	/**
	 * 后台Banner编辑保存
	 */
	public function toBannerEdit(Request $request, $bannerid)
	{
		$data = $request->except(['_token','_method','s']);
		
		$data['link_url'] = implode('::::::',$data['link_url']);
		
		//Base64 保存图片
		if(isset($data['banner_url'])){
			$fileroot = 'uploads/images/'.date("Ymd").'/';
			$data['banner_url'] = $this->basePic($data['banner_url'],$fileroot);
		}
		$re = Banner::where('banner_id',$bannerid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/banner/bannerlist',
        	];
		} else {
			$jsonData = [
	            'status'  => '0',
	            'message' => '编辑失败',
	        ];
		}
		return response()->json($jsonData);
	}
}