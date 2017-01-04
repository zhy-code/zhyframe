<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	/**
	 * Base64转化为图片
	 */
	public function basePic($dataarr,$fileroot){
		$pre = '::::::';
		$data = '';
		if(is_array($dataarr)){
			foreach($dataarr as $v){
				if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $v, $result)){
					$type = $result[2];
					$tempname = $this->randomchar(6);
					/* 文件不存在则新建 */
					if (!file_exists($fileroot)){
						mkdir($fileroot,0777,true); 
					} 
					$filename = md5(time().strtolower($tempname));
					$newfile = $fileroot.$filename.'.'.$type;
					
					$re = file_put_contents($newfile, base64_decode(str_replace($result[1], '', $v)));
					if($re){
						$data .= $newfile.$pre;
					}else{
						return Redirect::back();
					}
				}else{
					$data .= $v.$pre;
				}
			}
		}else{
			if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $dataarr, $result)){
				$type = $result[2];
				$tempname = $this->randomchar(6);
				
				/* 文件不存在则新建 */
				if (!file_exists($fileroot)){
					mkdir($fileroot,0777,true); 
				} 
				$filename = md5(time().strtolower($tempname));
				$newfile = $fileroot.$filename.'.'.$type;
				
				$re = file_put_contents($newfile, base64_decode(str_replace($result[1], '', $dataarr)));
				if($re){
					$data .= $newfile.$pre;
				}else{
					return Redirect::back();
				}
			}else{
				$data .= $dataarr.$pre;
			}
		}
		
		$restr = substr($data,0,-6);
		return $restr;
	}
	
	/**
     * 获取随机位数数字
     * @param  integer $len 长度
     * @return string       
     */
    protected static function randomchar($length=6,$numeric=0){
		
		if($numeric){
			$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
		}else{
			$hash = '';
			$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
			$max = strlen($chars) - 1;
			for($i = 0; $i < $length; $i++) {
				$hash .= $chars[mt_rand(0, $max)];
			}
		}
		return $hash;
	}
	//生成随机数,用于生成salt
    protected static function random_str($length)
    {
        //生成一个包含 大写英文字母, 小写英文字母, 数字 的数组
        $arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $str = '';
        $arr_len = count($arr);
        for ($i = 0; $i < $length; $i++){
            $rand = mt_rand(0, $arr_len-1);
            $str.=$arr[$rand];
        }
        return $str;
    }
   
    
}
