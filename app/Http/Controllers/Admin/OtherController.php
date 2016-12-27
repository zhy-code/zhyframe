<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Session;

class OtherController extends Controller
{
	/**
	 * 编辑器图片上传
	 */
	public function toUploads(Request $request)
	{
		$file = $request->file("file");
		
        $file_url = 'uploads/editor/images/'.date("Ymd");
		$fname = md5(time().rand(1000,10000));
		$extension = $file->getClientOriginalExtension();
        $newName = $fname.'.'.$extension;
		$result = $file->move($file_url, $newName);
		$jsonData = [
			'status' => 1,
			'url' => '/'.$result->getPathName(),
		];
		return response()->json($jsonData);
	}
}