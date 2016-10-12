<?php

namespace App\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Config;
use Redirect;
use Session;
use DB;
use App\Model\Feedback;
use Illuminate\Support\Facades\Input;

class FeedbackController extends Controller
{
    /*
     * 列表
     */
    public function index(Request $request, $id) {

        $model = Feedback::orderBy('id', 'desc');

        if ($request->has('username')) {
            $model->where('username', 'LIKE' , "%".$request->get('username')."%");
        }

        $feedbacks = $model->paginate(1);
        return view('admin.feedback.feedback_index', ['feedbacks' => $feedbacks]);
    }


    /*
     * 删除
     */
    public function destroy(Request $request) {

        $resultfeedback = feedback::destroy($request->get('id'));
        $state = $resultfeedback ? 200 : 0;
        return response()->json(['state' => $state]);
    }





}