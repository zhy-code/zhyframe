<?php
namespace App\Http\Controllers\Serstore;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Session;

use App\Models\Serstore;

class PublicController extends Controller
{

	public function __construct(){
		$user = Session::get('user');
		$user['serstore']=Serstore::where('user_id',$user['user_id'])->orderBy('store_id','desc')->first()->toArray();

		if($user['serstore']['store_status'] == 0){
			echo '<center style="color:red">该商铺不存在</center>';exit;
		}elseif($user['serstore']['store_status'] == -1){
			echo '<center style="color:red">该商铺被禁用</center>';exit;
		}else{
			Session::put('user',$user);
		}
	}
    
}
