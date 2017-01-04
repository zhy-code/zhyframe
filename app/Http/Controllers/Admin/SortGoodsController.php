<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\SortGoods;
use App\Model\SortGoodsShop;

class SortGoodsController extends Controller
{

	/**
	 * 后台分类列表
	 */
	public function sortgoodsList()
	{
		$sortgoods_parents = SortGoods::where('sortgoods_parent_id',0)->orderBy('sortgoods_sort','asc')->get();
        $sortgoodslist = $this->getChildStr($sortgoods_parents);
        $sortgoods_list_json = json_encode($sortgoodslist);
		return View::make('admin.sortgoods.sortgoodslist', ['sortgoodslist'=>$sortgoods_list_json]);
	}
	
	protected function getChildStr($sortgoodslist){
		if(count($sortgoodslist)){
			foreach ($sortgoodslist as $k => $sortgoods){
				$info[$k]['text'] = $sortgoods->sortgoods_name;
				
				$del    = "<i class='fa fa-trash-o' onclick=\"layListDel(this,'/admin/sortgoods/destroy','".$sortgoods->sortgoods_id."','reload')\"></i>";
				if($sortgoods->sortgoods_status){
					$updown = "<i class='fa fa-level-down' onclick=\"layChangeStatus('/admin/sortgoods/sortgoodsstatus/".$sortgoods->sortgoods_id."/0','隐藏')\"></i>";
				}else{
					$updown = "<i class='fa fa-level-up' onclick=\"layChangeStatus('/admin/sortgoods/sortgoodsstatus/".$sortgoods->sortgoods_id."/1','显示')\"></i>";
				}
				$edit   = "<i class='fa fa-edit' onclick=\"layOpenView('/admin/sortgoods/sortgoodsedit/".$sortgoods->sortgoods_id."','90%','90%','分类编辑')\"></i>";
				
				$info[$k]['tags'] = [$del,$updown,$edit];
				
				$childlist = SortGoods::where('sortgoods_parent_id', $sortgoods->sortgoods_id)->orderBy('sortgoods_sort','asc')->get();
				$info[$k]['nodes'] = $this->getChildStr($childlist);
			}
		}else{
			$info = '';
		}
		return $info;
	}
	
	/**
	 * 后台分类添加页面
	 */
	public function sortgoodsAdd()
	{
		$sortgoods_parentlist = SortGoods::where('sortgoods_parent_id',0)->orderBy('sortgoods_sort','asc')->get();
		$sortgoodslist = $this->getInfinite($sortgoods_parentlist,4*6,0);
		
		//商铺分类
		$sortgoodsshoplist = SortGoodsShop::where('sortgoodsshop_parent_id',0)->orderBy('sortgoodsshop_sort','asc')->get();
		
		return View::make('admin.sortgoods.sortgoodsadd',['sortgoodslist'=>$sortgoodslist, 'sortgoodsshoplist'=>$sortgoodsshoplist]);
	}
	
	//无限级获取
	protected function getInfinite($infolist,$width,$id){
		$htmlstr = '';
		if(count($infolist)){
			foreach ($infolist as $k => $info){
				$jg = substr('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',0,$width);
				$selected = ($id && $id==$info->sortgoods_id) ? 'selected' : '';
				$htmlstr .= '<option value="'.$info->sortgoods_id.'" '.$selected.'>'.$jg.$info->sortgoods_name.'</option>';
				$childlist = SortGoods::where('sortgoods_parent_id', $info->sortgoods_id)->orderBy('sortgoods_sort','asc')->get();
				$htmlstr .= $this->getInfinite($childlist,$width+4*6,$id);
			}
		}
		return $htmlstr;
	}
	
	/**
	 * 后台分类添加保存
	 */
	public function toSortGoodsAdd(Requests\SortGoodsRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		$data['sortgoods_status'] = 1;
		$re = SortGoods::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/sortgoods/sortgoodslist',
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
	 * 后台分类编辑页面
	 */
	public function sortgoodsEdit($sortgoodsid)
	{
		$sortgoods_info = SortGoods::find($sortgoodsid);
		$sortgoods_parentlist = SortGoods::where('sortgoods_parent_id',0)->orderBy('sortgoods_sort','asc')->get();
		$sortgoodslist = $this->getInfinite($sortgoods_parentlist,4*6, $sortgoods_info->sortgoods_parent_id);
		
		//商铺分类
		$sortgoodsshoplist = SortGoodsShop::where('sortgoodsshop_parent_id',0)->orderBy('sortgoodsshop_sort','asc')->get();
		
		return View::make('admin.sortgoods.sortgoodsedit', ['sortgoodsinfo'=>$sortgoods_info,'sortgoodslist'=>$sortgoodslist, 'sortgoodsshoplist'=>$sortgoodsshoplist]);
	}
	
	/**
	 * 后台分类编辑保存
	 */
	public function toSortGoodsEdit(Requests\SortGoodsRequest $request, $sortgoodsid)
	{
		$data = $request->except(['_token','_method','s']);
		$re = SortGoods::where('sortgoods_id',$sortgoodsid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/sortgoods/sortgoodslist',
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
	 * 后台分类变更状态
	 */
	public function toSortGoodsStatus($sortgoodsid, $status=0)
	{
		$sortgoods_info = SortGoods::find($sortgoodsid);
		$sortgoods_info->sortgoods_status = $status;
		$re = $sortgoods_info->save();
		if ($re) {
			
			//关联操作
			$this->statusLinkSon([$sortgoods_info->sortgoods_id],$status);
			
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/sortgoods/sortgoodslist',
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
	 * 后台分类删除
	 */
	public function toSortGoodsDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = SortGoods::destroy($ids);
		if ($re) {
			//关联删除
			$this->delLinkSon($ids);
			
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
	
	//关联变更状态
	protected function statusLinkSon($ids,$status){
		$child_ids = SortGoodsShop::whereIn('sortgoods_parent_id',$ids)->pluck('sortgoods_id');
		SortGoodsShop::whereIn('sortgoods_parent_id',$ids)->update(['sortgoods_status'=>$status]);
		if(count($child_ids)){
			$this->statusLinkSon($child_ids,$status);
		}
	}
	//关联删除
	protected function delLinkSon($ids){
		$child_ids = SortGoodsShop::whereIn('sortgoods_parent_id',$ids)->pluck('sortgoods_id');
		SortGoodsShop::whereIn('sortgoods_parent_id',$ids)->delete();
		if(count($child_ids)){
			$this->delLinkSon($child_ids);
		}
	}
}