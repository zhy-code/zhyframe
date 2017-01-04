<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\SortServiceShop;

class SortServiceShopController extends Controller
{

	/**
	 * 后台分类列表
	 */
	public function sortserviceshopList()
	{
		$sortserviceshop_parents = SortServiceShop::where('sortserviceshop_parent_id',0)->orderBy('sortserviceshop_sort','asc')->get();
        $sortserviceshoplist = $this->getChildStr($sortserviceshop_parents);
        $sortserviceshop_list_json = json_encode($sortserviceshoplist);
		return View::make('admin.sortserviceshop.sortserviceshoplist', ['sortserviceshoplist'=>$sortserviceshop_list_json]);
	}
	
	protected function getChildStr($sortserviceshoplist){
		if(count($sortserviceshoplist)){
			foreach ($sortserviceshoplist as $k => $sortserviceshop){
				$info[$k]['text'] = $sortserviceshop->sortserviceshop_name;
				
				$del    = "<i class='fa fa-trash-o' onclick=\"layListDel(this,'/admin/sortserviceshop/destroy','".$sortserviceshop->sortserviceshop_id."','reload')\"></i>";
				if($sortserviceshop->sortserviceshop_status){
					$updown = "<i class='fa fa-level-down' onclick=\"layChangeStatus('/admin/sortserviceshop/sortserviceshopstatus/".$sortserviceshop->sortserviceshop_id."/0','隐藏')\"></i>";
				}else{
					$updown = "<i class='fa fa-level-up' onclick=\"layChangeStatus('/admin/sortserviceshop/sortserviceshopstatus/".$sortserviceshop->sortserviceshop_id."/1','显示')\"></i>";
				}
				$edit   = "<i class='fa fa-edit' onclick=\"layOpenView('/admin/sortserviceshop/sortserviceshopedit/".$sortserviceshop->sortserviceshop_id."','90%','90%','分类编辑')\"></i>";
				
				$info[$k]['tags'] = [$del,$updown,$edit];
				
				$childlist = SortServiceShop::where('sortserviceshop_parent_id', $sortserviceshop->sortserviceshop_id)->orderBy('sortserviceshop_sort','asc')->get();
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
	public function sortserviceshopAdd()
	{
		$sortserviceshop_parentlist = SortServiceShop::where('sortserviceshop_parent_id',0)->orderBy('sortserviceshop_sort','asc')->get();
		$sortserviceshoplist = $this->getInfinite($sortserviceshop_parentlist,4*6,0);
		return View::make('admin.sortserviceshop.sortserviceshopadd',['sortserviceshoplist'=>$sortserviceshoplist]);
	}
	
	//无限级获取
	protected function getInfinite($infolist,$width,$id){
		$htmlstr = '';
		if(count($infolist)){
			foreach ($infolist as $k => $info){
				$jg = substr('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',0,$width);
				$selected = ($id && $id==$info->sortserviceshop_id) ? 'selected' : '';
				$htmlstr .= '<option value="'.$info->sortserviceshop_id.'" '.$selected.'>'.$jg.$info->sortserviceshop_name.'</option>';
				$childlist = SortServiceShop::where('sortserviceshop_parent_id', $info->sortserviceshop_id)->orderBy('sortserviceshop_sort','asc')->get();
				$htmlstr .= $this->getInfinite($childlist,$width+4*6,$id);
			}
		}
		return $htmlstr;
	}
	
	/**
	 * 后台分类添加保存
	 */
	public function toSortServiceShopAdd(Requests\SortServiceShopRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		$data['sortserviceshop_status'] = 1;
		$re = SortServiceShop::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/sortserviceshop/sortserviceshoplist',
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
	public function sortserviceshopEdit($sortserviceshopid)
	{
		$sortserviceshop_info = SortServiceShop::find($sortserviceshopid);
		$sortserviceshop_parentlist = SortServiceShop::where('sortserviceshop_parent_id',0)->orderBy('sortserviceshop_sort','asc')->get();
		$sortserviceshoplist = $this->getInfinite($sortserviceshop_parentlist,4*6, $sortserviceshop_info->sortserviceshop_parent_id);
		return View::make('admin.sortserviceshop.sortserviceshopedit', ['sortserviceshopinfo'=>$sortserviceshop_info,'sortserviceshoplist'=>$sortserviceshoplist]);
	}
	
	/**
	 * 后台分类编辑保存
	 */
	public function toSortServiceShopEdit(Requests\SortServiceShopRequest $request, $sortserviceshopid)
	{
		$data = $request->except(['_token','_method','s']);
		$re = SortServiceShop::where('sortserviceshop_id',$sortserviceshopid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/sortserviceshop/sortserviceshoplist',
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
	public function toSortServiceShopStatus($sortserviceshopid, $status=0)
	{
		$sortserviceshop_info = SortServiceShop::find($sortserviceshopid);
		$sortserviceshop_info->sortserviceshop_status = $status;
		$re = $sortserviceshop_info->save();
		if ($re) {
			
			//关联操作
			$this->statusLinkSon([$sortserviceshop_info->sortserviceshop_id],$status);
			
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/sortserviceshop/sortserviceshoplist',
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
	public function toSortServiceShopDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = SortServiceShop::destroy($ids);
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
		$child_ids = SortServiceShop::whereIn('sortserviceshop_parent_id',$ids)->pluck('sortserviceshop_id');
		SortServiceShop::whereIn('sortserviceshop_parent_id',$ids)->update(['sortserviceshop_status'=>$status]);
		if(count($child_ids)){
			$this->statusLinkSon($child_ids,$status);
		}
	}
	//关联删除
	protected function delLinkSon($ids){
		$child_ids = SortServiceShop::whereIn('sortserviceshop_parent_id',$ids)->pluck('sortserviceshop_id');
		SortServiceShop::whereIn('sortserviceshop_parent_id',$ids)->delete();
		if(count($child_ids)){
			$this->delLinkSon($child_ids);
		}
	}
}