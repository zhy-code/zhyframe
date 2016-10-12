<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use App\Model\ArticleClass;
use App\Model\Article;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller{
    
    //列表
    public function index(Request $request, $id) {
        $lists = $this->lists();
        $model = Article::orderBy('article_id', 'desc');
        if($request->has('ac_title')){
            $model->where('article_title', 'like', '%'.$request->get('ac_title').'%');
        }
        if($request->has('ac_class')){
            $model->where('ac_id', $request->get('ac_class'));
        }
        $article = $model->with('belongsToArticleClass')->paginate(2);
       return view('admin.website.article_index', ['ac_class'=>$lists, 'article'=>$article]);
    }

    //文章分类列表
    public function lists($select = null)
    {
        $string = '';
        $ac_class = ArticleClass::select('id' , 'ac_name')->where('parentid' , 0)->get();
        foreach ($ac_class as $key => $value)
        {
            $selected = $select == $value->id ? ' selected="selected"' : '';
            $string .= '<option '.$selected.' value="'.$value->id.'">'.$value->ac_name.'</option>';
            $parent_class = ArticleClass::select('id' , 'ac_name')->where('parentid' , $value->id)->get();
            if (count($parent_class) > 0)
            {
                foreach ($parent_class as $parentKey => $parentValue)
                {
                    $selected = $select == $parentValue->id ? ' selected="selected"' : '';
                    $string .= '<option '.$selected.' value="'.$parentValue->id.'">|------'.$parentValue->ac_name.'</option>';
                }
            }
        }
        return $string;
    }

    //刪除
    public function destroy(Request $request){
        $res = Article::destroy($request->get('id'));
        $state = $res ? 200 :0;
        return response()->json(['state' => $state]);
    }

    //新增视图
    public function create(){
        $lists = $this->lists();
       return view('admin.website.article_create', ['ac_class'=>$lists]);
    }
    
    //编辑
    public function edit($id, $article_id){
        $article = Article::find($article_id);
        $lists = $this->lists($article->ac_id);
       return view('admin.website.article_edit', ['article' => $article , 'ac_class' => $lists]);
    }

    //更新
    public function update(Request $request, $id){
		$data = Input::except('_token', '_method');
        $data['article_show'] = isset($data['article_show']) ? $data['article_show'] : 0;

        $rules = [
            'article_title' => 'required',
            'article_url' => 'required',
            'article_sort' => 'integer',
            'article_content'=> 'required'
        ];

        $errorMessage = [
            'article_title.required' => '标题不能为空',
            'article_url.required' => '文章链接不能为空',
            'article_sort.integer' => '排序必须为整数',
            'article_content.required' => '文章内容不能为空'
        ];

        $this->validate($request , $rules , $errorMessage);

        $article = Article::where('article_title' , $data['article_title'])->first();

        if (count($article) > 0 and $article->article_id != $id)
        {
            return Redirect::back()->withErrors('标题已存在');
        }

		$result = Article::where('article_id', $id)->update($data);

		if ($result) {
			return Redirect::to('admin/article/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
    }
    
    //新增文章
    public function store(Request $request) {

		$data = $request->except('_token');
        $data['article_time'] = time();
		//$data['ac_id'] = $data['ac_id'] == 0 ? 1 : $data['ac_id'];
		$data['article_show'] = isset($data['article_show']) ? $data['article_show'] : 0;
        $rules = [
            'article_title' => 'required|unique:article',
            'article_url' => 'required',
            'article_sort' => 'integer',
            'article_content'=> 'required'
        ];
        $errorMessages = [
            'article_title.required' => '标题不能为空',
            'article_title.unique' => '标题已存在',
            'article_sort.integer' => '排序必须为整数',
            'article_url.required' => '文章链接不能为空',
            //'article_url.active_url' => '文章链接不符合规范',
            'article_content.required' => '文章内容不能为空'
        ];
        $this->validate($request , $rules , $errorMessages);

        if ($data['ac_id'] == 0)
        {
            return back()->withErrors('请选择分类');
        }
		$result = Article::insert($data);
		if ($result) {
			return Redirect::to('admin/article/index/'.Session::get('menu_id'));
		} else {
			return Redirect::back();
		}
    }
}
