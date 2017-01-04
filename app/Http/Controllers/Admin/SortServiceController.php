<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Redirect;
use App\Model\SortService;
use App\Model\SortServiceShop;

class SortServiceController extends Controller
{

	/**
	 * 后台分类列表
	 */
	public function sortserviceList()
	{
		$sortservice_parents = SortService::where('sortservice_parent_id',0)->orderBy('sortservice_sort','asc')->get();
        $sortservicelist = $this->getChildStr($sortservice_parents);
        $sortservice_list_json = json_encode($sortservicelist);
		return View::make('admin.sortservice.sortservicelist', ['sortservicelist'=>$sortservice_list_json]);
	}
	
	protected function getChildStr($sortservicelist){
		if(count($sortservicelist)){
			foreach ($sortservicelist as $k => $sortservice){
				$info[$k]['text'] = $sortservice->sortservice_name;
				
				$del    = "<i class='fa fa-trash-o' onclick=\"layListDel(this,'/admin/sortservice/destroy','".$sortservice->sortservice_id."','reload')\"></i>";
				if($sortservice->sortservice_status){
					$updown = "<i class='fa fa-level-down' onclick=\"layChangeStatus('/admin/sortservice/sortservicestatus/".$sortservice->sortservice_id."/0','隐藏')\"></i>";
				}else{
					$updown = "<i class='fa fa-level-up' onclick=\"layChangeStatus('/admin/sortservice/sortservicestatus/".$sortservice->sortservice_id."/1','显示')\"></i>";
				}
				$edit   = "<i class='fa fa-edit' onclick=\"layOpenView('/admin/sortservice/sortserviceedit/".$sortservice->sortservice_id."','90%','90%','分类编辑')\"></i>";
				
				$info[$k]['tags'] = [$del,$updown,$edit];
				
				$childlist = SortService::where('sortservice_parent_id', $sortservice->sortservice_id)->orderBy('sortservice_sort','asc')->get();
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
	public function sortserviceAdd()
	{
		$sortservice_parentlist = SortService::where('sortservice_parent_id',0)->orderBy('sortservice_sort','asc')->get();
		$sortservicelist = $this->getInfinite($sortservice_parentlist,4*6,0);
		
		//商铺分类
		$sortserviceshoplist = SortServiceShop::where('sortserviceshop_parent_id',0)->orderBy('sortserviceshop_sort','asc')->get();
		
		return View::make('admin.sortservice.sortserviceadd',['sortservicelist'=>$sortservicelist, 'sortserviceshoplist'=>$sortserviceshoplist]);
	}
	
	//无限级获取
	protected function getInfinite($infolist,$width,$id){
		$htmlstr = '';
		if(count($infolist)){
			foreach ($infolist as $k => $info){
				$jg = substr('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',0,$width);
				$selected = ($id && $id==$info->sortservice_id) ? 'selected' : '';
				$htmlstr .= '<option value="'.$info->sortservice_id.'" '.$selected.'>'.$jg.$info->sortservice_name.'</option>';
				$childlist = SortService::where('sortservice_parent_id', $info->sortservice_id)->orderBy('sortservice_sort','asc')->get();
				$htmlstr .= $this->getInfinite($childlist,$width+4*6,$id);
			}
		}
		return $htmlstr;
	}
	
	/**
	 * 后台分类添加保存
	 */
	public function toSortServiceAdd(Requests\SortServiceRequest $request)
	{
		$data = $request->except(['_token','_method','s']);
		$data['sortservice_status'] = 1;
		$re = SortService::insert($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '增加成功',
		        'jumpurl' => '/admin/sortservice/sortservicelist',
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
	public function sortserviceEdit($sortserviceid)
	{
		$sortservice_info = SortService::find($sortserviceid);
		$sortservice_parentlist = SortService::where('sortservice_parent_id',0)->orderBy('sortservice_sort','asc')->get();
		$sortservicelist = $this->getInfinite($sortservice_parentlist,4*6, $sortservice_info->sortservice_parent_id);
		
		//商铺分类
		$sortserviceshoplist = SortServiceShop::where('sortserviceshop_parent_id',0)->orderBy('sortserviceshop_sort','asc')->get();
		
		return View::make('admin.sortservice.sortserviceedit', ['sortserviceinfo'=>$sortservice_info,'sortservicelist'=>$sortservicelist, 'sortserviceshoplist'=>$sortserviceshoplist]);
	}
	
	/**
	 * 后台分类编辑保存
	 */
	public function toSortServiceEdit(Requests\SortServiceRequest $request, $sortserviceid)
	{
		$data = $request->except(['_token','_method','s']);
		$re = SortService::where('sortservice_id',$sortserviceid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/sortservice/sortservicelist',
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
	public function toSortServiceStatus($sortserviceid, $status=0)
	{
		$sortservice_info = SortService::find($sortserviceid);
		$sortservice_info->sortservice_status = $status;
		$re = $sortservice_info->save();
		if ($re) {
			
			//关联操作
			$this->statusLinkSon([$sortservice_info->sortservice_id],$status);
			
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/sortservice/sortservicelist',
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
	public function toSortServiceDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = SortService::destroy($ids);
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
		$child_ids = SortServiceShop::whereIn('sortservice_parent_id',$ids)->pluck('sortservice_id');
		SortServiceShop::whereIn('sortservice_parent_id',$ids)->update(['sortservice_status'=>$status]);
		if(count($child_ids)){
			$this->statusLinkSon($child_ids,$status);
		}
	}
	//关联删除
	protected function delLinkSon($ids){
		$child_ids = SortServiceShop::whereIn('sortservice_parent_id',$ids)->pluck('sortservice_id');
		SortServiceShop::whereIn('sortservice_parent_id',$ids)->delete();
		if(count($child_ids)){
			$this->delLinkSon($child_ids);
		}
	}
}