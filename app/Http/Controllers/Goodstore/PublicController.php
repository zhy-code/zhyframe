<?php
namespace App\Http\Controllers\Goodstore;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\Models\Goodstore;

class PublicController extends Controller
{
	public function __construct(){

		$user = Session::get('user');
		$user['goodstore']=Goodstore::where('user_id',$user['user_id'])->orderBy('store_id','desc')->first()->toArray();

		if($user['goodstore']['store_status'] == 0){
			echo '<center style="color:red">该商铺不存在</center>';exit;
		}elseif($user['goodstore']['store_status'] == -1){
			echo '<center style="color:red">该商铺被禁用</center>';exit;
		}else{
			Session::put('user',$user);
		}
	}
    
}
