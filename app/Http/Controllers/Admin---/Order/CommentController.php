<?php

namespace App\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Config;
use Redirect;
use Session;
use DB;

use App\Model\Comment;

class CommentController extends Controller
{
    /*
     * 列表
     */
    public function index(Request $request, $id) {
        dd(session('admin'));
        $model = Comment::orderBy('comment_id', 'desc');
        if ($request->has('comment_orderno')) {
            $model->where('comment_orderno', $request->get('comment_orderno'));
        }
        $comments = $model->paginate(2);
        return view('admin.comment.comment_index', ['comments' => $comments]);
    }

    /*
     * 修改视图
     */
    public function edit($id, $comment_id) {
        $comment =  Comment::find($comment_id);
        return view('admin.comment.comment_edit', ['comment'=>$comment]);
    }

    /*
     * 更新
     */
    public function update(Request $request, $id) {
        $data = $request->except(['_token' , '_method']);
        $data['comment_state'] = $request->comment_state ? $request->comment_state  : 0;

        $rules = [
            'comment_scores' => 'integer | between:1,5 | required',
            'comment_content' => 'required'
        ];
        $errorMessages = [
            'comment_scores.integer' => '评分必须是整数',
            'comment_scores.required' => '评分不能为空',
            'comment_scores.between' => '评分必须在1到5之间',
            'comment_content.required' => '评论内容不能为空'
        ];
        $this->validate($request , $rules , $errorMessages);

        $result = Comment::where('comment_id', $id)->update($data);
        if ($result !== false) {
            return Redirect::to('admin/comment/index/'.Session::get('menu_id'));
        } else {
            return Redirect::back();
        }
    }

    /*
     * 删除
     */
    public function destroy(Request $request) {
        $resultComment = Comment::destroy($request->get('id'));
        $state = $resultComment ? 200 : 0;
        return response()->json(['state' => $state]);
    }

}