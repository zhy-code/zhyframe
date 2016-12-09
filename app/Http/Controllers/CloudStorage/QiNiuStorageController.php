<?php
namespace App\Http\Controllers\CloudStorage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QiNiuStorageController extends Controller
{
	
	private $ak = '_KRq-W2tjwnXsGDDWD530CdPGzlM8XW2KTnt7LKA';
	private $sk = 'ZDD-hnMja5AAwZsq_pRrb_vd9_Gtavs3WPqP5DWY';
	private $token;
	private $auth;
	protected $bucket = 'leehome';
	protected $imgurl = 'http://ognx9g5g0.bkt.clouddn.com';
	
	public function __construct($ak,$sk)
	{
		require_once(app_path().'/Library/Qiniu/autoload.php');
		
		if(!empty($sk)) $this->sk = $sk;
		if(!empty($ak)) $this->ak = $ak;
		$this->auth = new \Auth($this->ak,$this->sk);	
		$this->token = $this->auth->uploadToken($this->bucket);	
	}

    //获取图片全路径
    public function getFullImageUrl($imgName){
        return $this->imgurl.$imgName;
    }

	/*
		表单上传图片
		$fileName 文件名
		$tmpFile 文件
		$bucket  上传到指定空间
	*/
	public function upload($fileName='',$tmpFile){
		
		if(!$fileName){
            $fileName = time().rand(1000,9999);
        }
		
		$upload = new \UploadManager();
		$exists = $this->getFileInfo($fileName);
		if(!$exists){
			list($ret, $err) = $upload->putFile($this->token,$fileName,$tmpFile);
			if ($err !== null) {
				return $err;
			}
			return $ret['key'];
		}
		return $fileName;
	}
	
	/*
		base64上传图片
		$str base64字符串
	*/
	public function uploadBase($str){
		header('Access-Control-Allow-Origin:*');
		return $this->request_by_curl('http://up-z2.qiniu.com/putb64/-1',$str);
	}
	
	//获取图片信息
	public function getFileInfo($key){
		$bucketMgr = new \BucketManager($this->auth);

		list($ret, $err) = $bucketMgr->stat($this->bucket, $key);
		if ($err !== null) {
			return false;
		}
		return $ret;
	}
	
	public function getToken(){
	    return $this->token;
    }

	//获取图片路径
	public function getPath($key,$width=300,$height=0){
		$url = 'http://xlimages.qiniudn.com/'.$key.'?imageView2/';
		if($width > 0 && $height == 0){
			$url .= '2/w/'.$width;
		}else if($width == 0 && $height > 0){
			$url .= '2/h/'.$height;
		}else{
			$url .= '1/w/'.$width.'/h/'.$height;
		}
		return $url;
	}

	function request_by_curl($remote_server,$post_string) {  

	  $headers = array();
	  $headers[] = 'Content-Type:image/jpg';
	  $headers[] = 'Authorization:UpToken '.$this->token;
	  $ch = curl_init();  
	  curl_setopt($ch, CURLOPT_URL,$remote_server);  
	  //curl_setopt($ch, CURLOPT_HEADER, 0);
	  curl_setopt($ch, CURLOPT_HTTPHEADER ,$headers);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	  //curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	  $data = curl_exec($ch);  
	  curl_close($ch);  
	  
	  return $data;  
	}
}