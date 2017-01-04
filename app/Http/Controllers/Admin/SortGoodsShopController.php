<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\SortGoodsShop;

class SortGoodsShopController extends Controller
{

	/**
	 * 后台分类列表
	 */
	public function sortgoodsshopList()
	{
		$sortgoodsshop_parents = SortGoodsShop::where('sortgoodsshop_parent_id',0)->orderBy('sortgoodsshop_sort','asc')->get();
        $sortgoodsshoplist = $this->getChildStr($sortgoodsshop_parents);
        $sortgoodsshop_list_json = json_encode($sortgoodsshoplist);
		return View::make('admin.sortgoodsshop.sortgoodsshoplist', ['sortgoodsshoplist'=>$sortgoodsshop_list_json]);
	}
	
	protected function getChildStr($sortgoodsshoplist){
		if(count($sortgoodsshoplist)){
			foreach ($sortgoodsshoplist as $k => $sortgoodsshop){
				$info[$k]['text'] = $sortgoodsshop->sortgoodsshop_name;
				
				$del    = "<i class='fa fa-trash-o' onclick=\"layListDel(this,'/admin/sortgoodsshop/destroy','".$sortgoodsshop->sortgoodsshop_id."','reload')\"></i>";
				if($sortgoodsshop->sortgoodsshop_status){
					$updown = "<i class='fa fa-level-down' onclick=\"layChangeStatus('/admin/sortgoodsshop/sortgoodsshopstatus/".$sortgoodsshop->sortgoodsshop_id."/0','隐藏')\"></i>";
				}else{
					$updown = "<i class='fa fa-level-up' onclick=\"layChangeStatus('/admin/sortgoodsshop/sortgoodsshopstatus/".$sortgoodsshop->sortgoodsshop_id."/1','显示')\"></i>";
				}
				$edit   = "<i class='fa fa-edit' onclick=\"layOpenView('/admin/sortgoodsshop/sortgoodsshopedit/".$sortgoodsshop->sortgoodsshop_id."','90%','90%','分类编辑')\"></i>";
				
				$info[$k]['tags'] = [$del,$updown,$edit];
				
				$childlist = SortGoodsShop::where('sortgoodsshop_parent_id', $sortgoodsshop->sortgoodsshop_id)->orderBy('sortgoodsshop_sort','asc')->get();
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
	public function sortgoodsshopAdd()
	{
		$sortgoodsshop_parentlist = SortGoodsShop::where('sortgoodsshop_parent_id',0)->orderBy('sortgoodsshop_sort','asc')->get();
		$sortgoodsshoplist = $this->getInfinite($sortgoodsshop_parentlist,4*6,0);
		return View::make('admin.sortgoodsshop.sortgoodsshopadd',['sortgoodsshoplist'=>$sortgoodsshoplist]);
	}
	
	//无限级获取
	protected function getInfinite($infolist,$width,$id){
		$htmlstr = '';
		if(count($infolist)){
			foreach ($infolist as $k => $info){
				$jg = substr('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',0,$width);
				$selected = ($id && $id==$info->sortgoodsshop_id) ? 'selected' : '';
				$htmlstr .= '<option value="'.$info->sortgoodsshop_id.'" '.$selected.'>'.$jg.$info->sortgoodsshop_name.'</option>';
				$childlist = SortGoodsShop::where('sortgoodsshop_parent_id', $info->sortgoodsshop_id)->orderBy('sortgoodsshop_sort','asc')->get();
				$htmlstr .= $this->getInfinite($childlist,$width+4*6,$id);
			}
		}
		return $htmlstr;
	}
	
	/**
	 * 后台分类添加保存
	 */
	public function toSortGoodsShopAdd(Requests\SortGoodsShopRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		$data['sortgoodsshop_status'] = 1;
		$re = SortGoodsShop::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/sortgoodsshop/sortgoodsshoplist',
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
	public function sortgoodsshopEdit($sortgoodsshopid)
	{
		$sortgoodsshop_info = SortGoodsShop::find($sortgoodsshopid);
		$sortgoodsshop_parentlist = SortGoodsShop::where('sortgoodsshop_parent_id',0)->orderBy('sortgoodsshop_sort','asc')->get();
		$sortgoodsshoplist = $this->getInfinite($sortgoodsshop_parentlist,4*6, $sortgoodsshop_info->sortgoodsshop_parent_id);
		return View::make('admin.sortgoodsshop.sortgoodsshopedit', ['sortgoodsshopinfo'=>$sortgoodsshop_info,'sortgoodsshoplist'=>$sortgoodsshoplist]);
	}
	
	/**
	 * 后台分类编辑保存
	 */
	public function toSortGoodsShopEdit(Requests\SortGoodsShopRequest $request, $sortgoodsshopid)
	{
		$data = $request->except(['_token','_method','s']);
		$re = SortGoodsShop::where('sortgoodsshop_id',$sortgoodsshopid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/sortgoodsshop/sortgoodsshoplist',
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
	public function toSortGoodsShopStatus($sortgoodsshopid, $status=0)
	{
		$sortgoodsshop_info = SortGoodsShop::find($sortgoodsshopid);
		$sortgoodsshop_info->sortgoodsshop_status = $status;
		$re = $sortgoodsshop_info->save();
		if ($re) {
			
			//关联操作
			$this->statusLinkSon([$sortgoodsshop_info->sortgoodsshop_id],$status);
			
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/sortgoodsshop/sortgoodsshoplist',
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
	public function toSortGoodsShopDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = SortGoodsShop::destroy($ids);
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
		$child_ids = SortGoodsShop::whereIn('sortgoodsshop_parent_id',$ids)->pluck('sortgoodsshop_id');
		SortGoodsShop::whereIn('sortgoodsshop_parent_id',$ids)->update(['sortgoodsshop_status'=>$status]);
		if(count($child_ids)){
			$this->statusLinkSon($child_ids,$status);
		}
	}
	//关联删除
	protected function delLinkSon($ids){
		$child_ids = SortGoodsShop::whereIn('sortgoodsshop_parent_id',$ids)->pluck('sortgoodsshop_id');
		SortGoodsShop::whereIn('sortgoodsshop_parent_id',$ids)->delete();
		if(count($child_ids)){
			$this->delLinkSon($child_ids);
		}
	}
}