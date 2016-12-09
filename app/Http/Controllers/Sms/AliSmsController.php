<?php

namespace App\Http\Controllers\Sms;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AliSmsController extends Controller
{	
	public $appkey = '23534193';
	private $secret = 'd9673276273cb46d9ffbcdf72a4d4159';
	private $sms_type = 'SMS_14510093';
	
	function __construct(){
		require_once(app_path().'/Library/AlidayuSms/TopSdk.php');
	}
	
	//发送短信（验证码）
	public function doSms($phone,$txt){
		date_default_timezone_set('Asia/Shanghai');
		$c = new \TopClient;
		$c->appkey = $this->appkey;
		$c->secretKey = $this->secret;
		$req = new \AlibabaAliqinFcSmsNumSendRequest;
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("车漫行");
		$req->setSmsParam ( "{name:'车漫行',code:\"$txt\"}" );
		$req->setRecNum($phone);
		$req->setSmsTemplateCode($this->sms_type);
		$resp = $c->execute($req);
		return $resp;
	}
	
	//发送短信（信息通知）
	public function doSmsInfo($phone,$name,$fname,$fcode){
		date_default_timezone_set('Asia/Shanghai'); 
    	$c = new \TopClient;
		$c->appkey = $this->appkey;
		$c->secretKey = $this->secret;
		$sms_type = 'SMS_27435260';
		$req = new \AlibabaAliqinFcSmsNumSendRequest;
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("车漫行");
		$req->setSmsParam ( "{name:\"$name\",fname:\"$fname\",fcode:\"$fcode\"}" );
		$req->setRecNum($phone);
		$req->setSmsTemplateCode($sms_type);
		$resp = $c->execute($req);
		return $resp;
	}
	
	
	//发送短信（发送密码）
	public function doSmsPasswd($phone,$passwd){
		date_default_timezone_set('Asia/Shanghai'); 
    	$c = new \TopClient;
		$c->appkey = $this->appkey;
		$c->secretKey = $this->secret;
		$sms_type = 'SMS_30265111';
		$req = new \AlibabaAliqinFcSmsNumSendRequest;
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("车漫行");
		$req->setSmsParam ( "{passwd:\"$passwd\"}" );
		$req->setRecNum($phone);
		$req->setSmsTemplateCode($sms_type);
		$resp = $c->execute($req);
		return $resp;
	}
}