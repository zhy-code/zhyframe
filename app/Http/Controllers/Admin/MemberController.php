<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use View;
use Session;
use Redirect;
use App\Model\Member;

class MemberController extends Controller
{
	/**
	 * 后台会员列表
	 */
	public function memberList()
	{
		$member_list = Member::get()->toArray();
		$member_list_json = json_encode($member_list);
		return View::make('admin.member.memberlist', ['memberlist'=>$member_list_json]);
	}
	
	/**
	 * 后台会员编辑页面
	 */
	public function memberEdit($memberid)
	{
		$member_info = Member::find($memberid);
		return View::make('admin.member.memberedit', ['memberinfo'=>$member_info]);
	}
	
	/**
	 * 后台会员编辑保存
	 */
	public function toMemberEdit(Requests\MemberEditRequest $request, $memberid)
	{
		$data = $request->except(['_token','_method','s']);
		if($request->get('member_password')){
			$data['member_password'] = Hash::make(md5($data['member_password']));
		}
		$data['member_edit_time'] = time();
		$data['member_edit_ip'] = $request->getClientIp();
		$re = Member::where('member_id',$memberid)->update($data);
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '编辑成功',
		        'jumpurl' => '/admin/member/memberlist',
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
	 * 后台会员变更状态
	 */
	public function toMemberStatus($memberid, $status=0)
	{
		$member_info = Member::find($memberid);
		$member_info->member_status = $status;
		$re = $member_info->save();
		if ($re) {
			$jsonData = [
        		'status'  => '1',
		        'message' => '变更成功',
		        'jumpurl' => '/admin/member/memberlist',
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
	 * 后台会员删除
	 */
	public function toMemberDestroy(Request $request)
	{
		$ids = explode(',', $request->get('id'));
		$re = Member::destroy($ids);
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