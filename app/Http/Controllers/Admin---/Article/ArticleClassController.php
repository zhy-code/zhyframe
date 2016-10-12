<?php

namespace App\Http\Controllers\Admin\Article;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use View;
use App\Model\ArticleClass;
use Illuminate\Support\Facades\Input;
use Redirect;
use Session;

class ArticleClassController extends Controller
{
    //列表
    public function index($id){
        $data = ArticleClass::where('parentid', 0)->get();
        return View::make('admin.website.articleclass_index', ['data' => $data]);
    }
    
    //新增
    public function create($id){
        $parent_id = 0;
        $data = ArticleClass::where('parentid', 0)->get();
        return View::make('admin.website.articleclass_create', ['data' => $data, 'parent_id' => $parent_id]);
    }
    
    //编辑
    public function edit($menu_id, $id){
        $data = ArticleClass::where('parentid', 0)->get();
        $articleclass = ArticleClass::find($id);
        return View::make('admin.website.articleclass_edit', ['data' => $data, 'articleclass' => $articleclass]);
    }
    
    //更新
    public function update(Request $request, $id){
        $data = $request->except('_token','_method');
        $rules = [
            'ac_code' => 'required',
            'ac_name' => 'required',
            'ac_sort' => 'integer'
        ];
        $errorMessages = [
            'ac_code.required' => '分类标识码不能为空',
            'ac_name.required' => '分类名称不能为空',
            'ac_sort.integer' => '排序必须是整数'
        ];
        $this->validate($request , $rules , $errorMessages);
        $result = ArticleClass::where('id', $id)->update($data);
        if($result){
            return Redirect::to('admin/articleclass/index/'.Session::get('menu_id'));
        }else{
            return redirect()->back();
        }
    }
    
    //储存
    public function store(Request $request){
        $data = $request->except('_token');
        $rules = [
            'ac_code' => 'required',
            'ac_name' => 'required',
            'ac_sort' => 'integer'
        ];
        $errorMessages = [
            'ac_code.required' => '分类标识码不能为空',
            'ac_name.required' => '分类名称不能为空',
            'ac_sort.integer' => '排序必须是整数'
        ];
        $this->validate($request , $rules , $errorMessages);
        $result = ArticleClass::insert($data);
        if($result){
            return Redirect::to('admin/articleclass/index/'.Session::get('menu_id'));
        }else{
            return redirect()->back();
        }
    }
    
    //新增子分类
    public function createSon($id, $parent_id){
        $data = ArticleClass::where('parentid', 0)->get();
        return View::make('admin.website.articleclass_create', ['data' => $data, 'parent_id' => $parent_id]);
    }
    
    //ajax获取子分类列表
    public function ajaxson(Request $request){
        $result = ArticleClass::where('parentid', $request->id)->get();
        $code = count($result) > 0 ? 200 : 0;
        return response()->json(['data' => $result, 'state' => $code]);
    }
    
    //删除分类
    public function destroy(Request $request){
        $result = ArticleClass::destroy($request->get('id'));
        $state = $result ? 200 : 0;
        return response()->json(['state' => $state]);
    }
}
