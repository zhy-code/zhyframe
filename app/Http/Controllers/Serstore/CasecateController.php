<?php
namespace App\Http\Controllers\Serstore;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use DB;
use Session;
use App\Models\Casecate;

class CasecateController extends PublicController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store_id = Session::get('user')['serstore']['store_id'];
        $result = Casecate::where('store_id',$store_id)->OrderBy('sort', 'desc')->OrderBy('cate_id', 'asc')->paginate(10);
        return view('serstore.casecate.index',compact('result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=0)
    {

        return view('serstore.casecate.create',compact('id'));
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
        Casecate::create($data);
        return redirect(url('serstore/casecate'));
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
        $resule = Casecate::findOrFail($id);
        return view('serstore.casecate.edit', compact('resule'));
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
        
        $resule = Casecate::findOrFail($id);
        $resule->update($request->only(['cate_name',  'sort']));
        return redirect(url('serstore/casecate'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = Casecate::where('cate_parentid',$id)->count();
        if($count > 0)
            return -1;
        if (Casecate::destroy($id))
            return 1;
        else
            return 0;
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->only(['id']);
        $ids = explode(",",$ids['id']);
        $chll_count = Casecate::whereIn('cate_parentid',$ids)->count();//判断是否存在子类，如果有则必须先删除完子类才能删除上级分类
        if($chll_count > 0)
            return -1;
        
        if (Casecate::whereIn('cate_id',$ids)->delete())
            return 1;
        else
            return 0;
    }
}
