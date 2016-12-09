<?php
namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Redirect;

/**
 * JSAPI支付实现类
 * 该类实现了从微信公众平台获取code、通过code获取openid和access_token、
 * 生成jsapi支付js接口所需的参数、生成获取共享收货地址所需的参数
 * 
 * 该类是微信支付提供的样例程序，商户可根据自己的需求修改，或者使用lib中的api自行开发
 */
 
class WxPayJsApiController extends Controller {

	public function __construct(){
		header("Content-type:text/html;charset=utf-8");
		//微信支付API
		require_once(app_path().'/Library/Wxpay/lib/WxPayConfig.php');
		require_once(app_path().'/Library/Wxpay/lib/WxPayData.php');
		require_once(app_path().'/Library/Wxpay/lib/WxPayException.php');
		require_once(app_path().'/Library/Wxpay/lib/WxPayNotify.php');
		require_once(app_path().'/Library/Wxpay/lib/WxPayApi.php');
		require_once(app_path().'/Library/Wxpay/log.php');
		
		date_default_timezone_set('Asia/Shanghai');
		
    }
	
	public $data = null;
	
	function weixinxpay($info){
		
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($info['body']);
		$input->SetAttach($info['attach']);
		$input->SetOut_trade_no($info['out_trade_no']);
		$input->SetTotal_fee($info['total_fee']);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis",time()+600));
		$input->SetGoods_tag($info['tag']);
		$input->SetNotify_url($info['notifyurl']);
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($info['openid']);
		$order = \WxPayApi::unifiedOrder($input);
		$jsApiParameters = $this->GetJsApiParameters($order);

		return $jsApiParameters;
	}
	
	/**
	 * 
	 * 获取jsapi支付的参数
	 * @param array $UnifiedOrderResult 统一支付接口返回的数据
	 * @throws WxPayException
	 * 
	 * @return json数据，可直接填入js函数作为参数
	 */
	public function GetJsApiParameters($UnifiedOrderResult){
		if(!array_key_exists("appid", $UnifiedOrderResult)|| !array_key_exists("prepay_id", $UnifiedOrderResult)|| $UnifiedOrderResult['prepay_id'] == ""){
			throw new \WxPayException("参数错误");
		}
		$jsapi = new \WxPayJsApiPay();
		$jsapi->SetAppid($UnifiedOrderResult["appid"]);
		$timeStamp = time();
		$jsapi->SetTimeStamp("$timeStamp");
		$jsapi->SetNonceStr(\WxPayApi::getNonceStr());
		$jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
		$jsapi->SetSignType("MD5");
		$jsapi->SetPaySign($jsapi->MakeSign());
		$parameters = json_encode($jsapi->GetValues());
		return $parameters;
	}
	
	/**
	 * 
	 * 拼接签名字符串
	 * @param array $urlObj
	 * 
	 * @return 返回已经拼接好的字符串
	 */
	private function ToUrlParams($urlObj){
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 * 
	 * 获取地址js参数
	 * 
	 * @return 获取共享收货地址js函数需要的参数，json格式可以直接做参数使用
	 */
	public function GetEditAddressParameters(){	
		$getData = $this->data;
		$data = array();
		$data["appid"] = \WxPayConfig::APPID;
		$data["url"] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$time = time();
		$data["timestamp"] = "$time";
		$data["noncestr"] = "1234568";
		$data["accesstoken"] = $getData["access_token"];
		ksort($data);
		$params = $this->ToUrlParams($data);
		$addrSign = sha1($params);
		
		$afterData = array(
			"addrSign" => $addrSign,
			"signType" => "sha1",
			"scope" => "jsapi_address",
			"appId" => \WxPayConfig::APPID,
			"timeStamp" => $data["timestamp"],
			"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
		return $parameters;
	}
	
}