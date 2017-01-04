<?php

namespace App\Http\Controllers\Goodstore;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use DB;
use Session;
use App\Models\Log;
class LogController extends PublicController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store_id = Session::get('user')['goodstore']['store_id'];

        $result = Log::where('store_id',$store_id)->OrderBy('sort', 'desc')->OrderBy('log_id', 'asc')->paginate(10);
        return view('goodstore.log.index',compact('result'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('goodstore.log.create');
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
        Log::create($data);
        return redirect(url('goodstore/log'));
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
        $result = Log::findOrFail($id);
        return view('goodstore.log.edit', compact('result'));
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
        $goodcate = Log::findOrFail($id);
        $goodcate->update($request->except('_token'));
        return redirect(url('goodstore/log'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Log::destroy($id))
            return 1;
        else
            return 0;
    }
    public function destroyAll(Request $request)
    {
        $ids = $request->only(['id']);
        $ids = explode(",",$ids['id']);
        if (Log::whereIn('log_id',$ids)->delete())
            return 1;
        else
            return 0;
    }
}
