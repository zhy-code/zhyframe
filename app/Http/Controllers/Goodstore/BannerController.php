<?php
namespace App\Http\Controllers\Goodstore;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Session;

use App\Models\Banner;

class BannerController extends PublicController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $store_id = Session::get('user')['goodstore']['store_id'];
        $result = Banner::where('goodstore_id',1)->OrderBy('sort', 'desc')->OrderBy('banner_id', 'asc')->paginate(10);

        return view('goodstore.banner.index',compact('result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('goodstore.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token','banner_file']);
        Banner::create($data);
        return redirect(url('goodstore/banner'));
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
        $result = Banner::findOrFail($id);
        return view('goodstore.banner.edit', compact('result'));
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
        $goodcate = Banner::findOrFail($id);
        $goodcate->update($request->except('_token','banner_file'));
        return redirect(url('goodstore/banner'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Banner::destroy($id))
            return 1;
        else
            return 0;
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->only(['id']);
        $ids = explode(",",$ids['id']);
        if (Banner::whereIn('banner_id',$ids)->delete())
            return 1;
        else
            return 0;
    }
}
