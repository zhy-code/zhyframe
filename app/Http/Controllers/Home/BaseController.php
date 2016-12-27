<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Session;

class BaseController extends Controller
{

	protected $common_info;

	public function __construct()
	{
		//站点信息
		$this->common_info['siteinfo'] = DB::table('site_info')->first();
		
		//加入我们信息
		$this->common_info['joininfo'] = DB::table('column_joinus')->get();
		
		//旗下公司信息
		$this->common_info['all_groupinfo'] = DB::table('column_cgroup')->get();
		$this->common_info['inweb_groupinfo'] = DB::table('column_cgroup')->where('classify',1)->get();
	}
	
	public function getBanner($id){
		$banner_info = DB::table('banner')->where('banner_id',$id)->first();
		$data['banner_url'] = explode('::::::',$banner_info->banner_url);
		$data['link_url'] = explode('::::::',$banner_info->link_url);
		return $data;
	}
}