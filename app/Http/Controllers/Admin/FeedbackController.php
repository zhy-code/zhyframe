<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use View;
use DB;
use Session;
use Redirect;
use App\Model\Feedback;

class FeedbackController extends Controller
{
	/**
	 * 后台反馈列表
	 */
	public function feedbackList()
	{
		$feedback_list = Feedback::get()->toArray();
		$feedback_list_json = json_encode($feedback_list);
		return View::make('admin.feedback.feedbacklist', ['feedbacklist'=>$feedback_list_json]);
	}
	
	
	/**
	 * 后台充值记录备注
	 */
	public function toFeedbackRemark(Request $request)
	{
        $id = $request->get('id');
        $re = Feedback::where('id',$id)->update(['remark'=>$request->get('content')]);
        if ($re) {
            $jsonData = [
                'status'  => '1',
                'message' => '备注成功',
            ];
        } else {
            $jsonData = [
                'status'  => '0',
                'message' => '备注失败',
            ];
        }
        return response()->json($jsonData);
	}

}