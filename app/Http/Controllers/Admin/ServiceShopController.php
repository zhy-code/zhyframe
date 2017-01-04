<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use View;
use Session;
use Redirect;
use App\Model\ServiceShop;

class ServiceShopController extends Controller
{
	/**
	 * 后台商品商铺列表
	 */
	public function serviceshopList()
	{
		$serviceshop_list = ServiceShop::get()->toArray();
		$serviceshop_list_json = json_encode($serviceshop_list);
		return View::make('admin.serviceshop.serviceshoplist', ['serviceshoplist'=>$serviceshop_list_json]);
	}
	
	/**
	 * 后台商品商铺编辑页面
	 */
	public function serviceshopEdit($serviceshopid)
	{
		$serviceshop_info = ServiceShop::find($serviceshopid);
		return View::make('admin.serviceshop.serviceshopedit', ['serviceshopinfo'=>$serviceshop_info]);
	}
	
	/**
	 * 后台商品商铺编辑保存
	 */
	public function toServiceShopEdit(Requests\ServiceShopEditRequest $request, $serviceshopid)
	{
		$data = $request->except(['_token','_method','s']);
		if($request->get('serviceshop_password')){
			$data['serviceshop_password'] = Hash::make(md5($data['serviceshop_password']));
		}
		$data['serviceshop_edit_time'] = time();
		$data['serviceshop_edit_ip'] = $request->getClientIp();
		$re = ServiceShop::where('serviceshop_id',$serviceshopid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/serviceshop/serviceshoplist',
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
     * 后台商品商铺详情
     */
    public function serviceshopDetails($serviceshopid)
    {
        $serviceshop_info = ServiceShop::where('serviceshop_id',$serviceshopid)->first();
        return View::make('admin.serviceshop.serviceshopdetails', ['serviceshopinfo'=>$serviceshop_info]);
    }

	
	/**
	 * 后台商品商铺变更状态
	 */
	public function toServiceShopStatus($serviceshopid, $status=0)
	{
		$serviceshop_info = ServiceShop::find($serviceshopid);
		$serviceshop_info->serviceshop_status = $status;
		$re = $serviceshop_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/serviceshop/serviceshoplist',
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
	 * 后台商品商铺删除
	 */
	public function toServiceShopDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = ServiceShop::destroy($ids);
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