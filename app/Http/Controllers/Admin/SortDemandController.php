<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\SortDemand;

class SortDemandController extends Controller
{

	/**
	 * 后台分类列表
	 */
	public function sortdemandList()
	{
		$sortdemand_parents = SortDemand::where('sortdemand_parent_id',0)->orderBy('sortdemand_sort','asc')->get();
        $sortdemandlist = $this->getChildStr($sortdemand_parents);
        $sortdemand_list_json = json_encode($sortdemandlist);
		return View::make('admin.sortdemand.sortdemandlist', ['sortdemandlist'=>$sortdemand_list_json]);
	}
	
	protected function getChildStr($sortdemandlist){
		if(count($sortdemandlist)){
			foreach ($sortdemandlist as $k => $sortdemand){
				$info[$k]['text'] = $sortdemand->sortdemand_name;
				
				$del    = "<i class='fa fa-trash-o' onclick=\"layListDel(this,'/admin/sortdemand/destroy','".$sortdemand->sortdemand_id."','reload')\"></i>";
				if($sortdemand->sortdemand_status){
					$updown = "<i class='fa fa-level-down' onclick=\"layChangeStatus('/admin/sortdemand/sortdemandstatus/".$sortdemand->sortdemand_id."/0','隐藏')\"></i>";
				}else{
					$updown = "<i class='fa fa-level-up' onclick=\"layChangeStatus('/admin/sortdemand/sortdemandstatus/".$sortdemand->sortdemand_id."/1','显示')\"></i>";
				}
				$edit   = "<i class='fa fa-edit' onclick=\"layOpenView('/admin/sortdemand/sortdemandedit/".$sortdemand->sortdemand_id."','90%','90%','分类编辑')\"></i>";
				
				$info[$k]['tags'] = [$del,$updown,$edit];
				
				$childlist = SortDemand::where('sortdemand_parent_id', $sortdemand->sortdemand_id)->orderBy('sortdemand_sort','asc')->get();
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
	public function sortdemandAdd()
	{
		$sortdemand_parentlist = SortDemand::where('sortdemand_parent_id',0)->orderBy('sortdemand_sort','asc')->get();
		$sortdemandlist = $this->getInfinite($sortdemand_parentlist,4*6,0);
		return View::make('admin.sortdemand.sortdemandadd',['sortdemandlist'=>$sortdemandlist]);
	}
	
	//无限级获取
	protected function getInfinite($infolist,$width,$id){
		$htmlstr = '';
		if(count($infolist)){
			foreach ($infolist as $k => $info){
				$jg = substr('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',0,$width);
				$selected = ($id && $id==$info->sortdemand_id) ? 'selected' : '';
				$htmlstr .= '<option value="'.$info->sortdemand_id.'" '.$selected.'>'.$jg.$info->sortdemand_name.'</option>';
				$childlist = SortDemand::where('sortdemand_parent_id', $info->sortdemand_id)->orderBy('sortdemand_sort','asc')->get();
				$htmlstr .= $this->getInfinite($childlist,$width+4*6,$id);
			}
		}
		return $htmlstr;
	}
	
	/**
	 * 后台分类添加保存
	 */
	public function toSortDemandAdd(Requests\SortDemandRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		$data['sortdemand_status'] = 1;
		$re = SortDemand::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/sortdemand/sortdemandlist',
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
	public function sortdemandEdit($sortdemandid)
	{
		$sortdemand_info = SortDemand::find($sortdemandid);
		$sortdemand_parentlist = SortDemand::where('sortdemand_parent_id',0)->orderBy('sortdemand_sort','asc')->get();
		$sortdemandlist = $this->getInfinite($sortdemand_parentlist,4*6, $sortdemand_info->sortdemand_parent_id);
		return View::make('admin.sortdemand.sortdemandedit', ['sortdemandinfo'=>$sortdemand_info,'sortdemandlist'=>$sortdemandlist]);
	}
	
	/**
	 * 后台分类编辑保存
	 */
	public function toSortDemandEdit(Requests\SortDemandRequest $request, $sortdemandid)
	{
		$data = $request->except(['_token','_method','s']);
		$re = SortDemand::where('sortdemand_id',$sortdemandid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/sortdemand/sortdemandlist',
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
	public function toSortDemandStatus($sortdemandid, $status=0)
	{
		$sortdemand_info = SortDemand::find($sortdemandid);
		$sortdemand_info->sortdemand_status = $status;
		$re = $sortdemand_info->save();
		if ($re) {
			
			//关联操作
			$this->statusLinkSon([$sortdemand_info->sortdemand_id],$status);
			
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/sortdemand/sortdemandlist',
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
	public function toSortDemandDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = SortDemand::destroy($ids);
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
		$child_ids = SortDemand::whereIn('sortdemand_parent_id',$ids)->pluck('sortdemand_id');
		SortDemand::whereIn('sortdemand_parent_id',$ids)->update(['sortdemand_status'=>$status]);
		if(count($child_ids)){
			$this->statusLinkSon($child_ids,$status);
		}
	}
	//关联删除
	protected function delLinkSon($ids){
		$child_ids = SortDemand::whereIn('sortdemand_parent_id',$ids)->pluck('sortdemand_id');
		SortDemand::whereIn('sortdemand_parent_id',$ids)->delete();
		if(count($child_ids)){
			$this->delLinkSon($child_ids);
		}
	}
}