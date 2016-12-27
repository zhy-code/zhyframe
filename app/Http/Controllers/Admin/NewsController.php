<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\News;

class NewsController extends Controller
{

	/**
	 * 后台新闻列表
	 */
	public function newsList()
	{
		$news_list = News::orderBy('edit_time','asc')->get();
        $news_list_json = json_encode($news_list);
		return View::make('admin.news.newslist', ['newslist'=>$news_list_json]);
	}
	
	/**
	 * 后台新闻添加页面
	 */
	public function newsAdd()
	{
		return View::make('admin.news.newsadd');
	}
	
	/**
	 * 后台新闻添加保存
	 */
	public function toNewsAdd(Requests\NewsRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		
		//Base64 保存图片
		$fileroot = 'uploads/images/'.date("Ymd").'/';
		$data['title_pic'] = $this->basePic($data['title_pic'],$fileroot);
		
		$data['status'] = 1;
		$data['add_time'] = time();
		$data['edit_time'] = time();
		$re = News::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/news/newslist',
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
	public function newsEdit($newsid)
	{
		$news_info = News::find($newsid);
		return View::make('admin.news.newsedit', ['newsinfo'=>$news_info]);
	}
	
	/**
	 * 后台新闻编辑保存
	 */
	public function toNewsEdit(Requests\NewsRequest $request, $newsid)
	{
		$data = $request->except(['_token','_method','s']);
		
		//Base64 保存图片
		$fileroot = 'uploads/images/'.date("Ymd");
		$data['title_pic'] = $this->basePic($data['title_pic'],$fileroot);
		
		$data['edit_time'] = time();
		
		$re = News::where('id',$newsid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/news/newslist',
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
	public function toNewsStatus($newsid, $status=0)
	{
		$news_info = News::find($newsid);
		$news_info->status = $status;
		$re = $news_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/news/newslist',
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
	public function toNewsDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = News::destroy($ids);
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