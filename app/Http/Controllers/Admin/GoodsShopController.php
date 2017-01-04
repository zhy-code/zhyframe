<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use View;
use Session;
use Redirect;
use App\Model\GoodsShop;

class GoodsShopController extends Controller
{
	/**
	 * 后台商品商铺列表
	 */
	public function goodsshopList()
	{
		$goodsshop_list = GoodsShop::get()->toArray();
		$goodsshop_list_json = json_encode($goodsshop_list);
		return View::make('admin.goodsshop.goodsshoplist', ['goodsshoplist'=>$goodsshop_list_json]);
	}
	
	/**
	 * 后台商品商铺编辑页面
	 */
	public function goodsshopEdit($goodsshopid)
	{
		$goodsshop_info = GoodsShop::find($goodsshopid);
		return View::make('admin.goodsshop.goodsshopedit', ['goodsshopinfo'=>$goodsshop_info]);
	}
	
	/**
	 * 后台商品商铺编辑保存
	 */
	public function toGoodsShopEdit(Requests\GoodsShopEditRequest $request, $goodsshopid)
	{
		$data = $request->except(['_token','_method','s']);
		if($request->get('goodsshop_password')){
			$data['goodsshop_password'] = Hash::make(md5($data['goodsshop_password']));
		}
		$data['goodsshop_edit_time'] = time();
		$data['goodsshop_edit_ip'] = $request->getClientIp();
		$re = GoodsShop::where('goodsshop_id',$goodsshopid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/goodsshop/goodsshoplist',
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
    public function goodsshopDetails($goodsshopid)
    {
        $goodsshop_info = GoodsShop::where('goodsshop_id',$goodsshopid)->first();
        return View::make('admin.goodsshop.goodsshopdetails', ['goodsshopinfo'=>$goodsshop_info]);
    }

	
	/**
	 * 后台商品商铺变更状态
	 */
	public function toGoodsShopStatus($goodsshopid, $status=0)
	{
		$goodsshop_info = GoodsShop::find($goodsshopid);
		$goodsshop_info->goodsshop_status = $status;
		$re = $goodsshop_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/goodsshop/goodsshoplist',
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
	public function toGoodsShopDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = GoodsShop::destroy($ids);
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