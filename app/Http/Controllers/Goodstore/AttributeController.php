<?php

namespace App\Http\Controllers\Goodstore;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use DB;
use Session;
use App\Models\Attribute;
class AttributeController extends PublicController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store_id = Session::get('user')['goodstore']['store_id'];

        $result = Attribute::where('store_id',$store_id)->OrderBy('sort', 'desc')->OrderBy('attr_id', 'asc')->paginate(10);
        return view('goodstore.attribute.index',compact('result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=0)
    {

        return view('goodstore.attribute.create',compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        Attribute::create($data);
        return redirect(url('goodstore/attribute'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Attribute::findOrFail($id);
        return view('goodstore.attribute.edit', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $goodcate = Attribute::findOrFail($id);
        $goodcate->update($request->only(['attr_name',  'sort']));
        return redirect(url('goodstore/attribute'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = Attribute::where('attr_parentid',$id)->count();
        if($count > 0)
            return -1;
        if (Attribute::destroy($id))
            return 1;
        else
            return 0;
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->only(['id']);
        $ids = explode(",",$ids['id']);
        $chll_count = Attribute::whereIn('attr_parentid',$ids)->count();//判断是否存在子类，如果有则必须先删除完子类才能删除上级分类
        if($chll_count > 0)
            return -1;
        
        if (Attribute::whereIn('attr_id',$ids)->delete())
            return 1;
        else
            return 0;
    }
}
