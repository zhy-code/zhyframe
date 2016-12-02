<?php
namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Redirect;

/**
 * 刷卡支付实现类
 */
class WxPayNativeController extends Controller {
	
	public function __construct(){
		header("Content-type:text/html;charset=utf-8");
		//微信支付API
		require_once(app_path().'/Library/Wxpay/lib/WxPayConfig.php');
		require_once(app_path().'/Library/Wxpay/lib/WxPayData.php');
		require_once(app_path().'/Library/Wxpay/lib/WxPayException.php');
		require_once(app_path().'/Library/Wxpay/lib/WxPayNotify.php');
		require_once(app_path().'/Library/Wxpay/lib/WxPayApi.php');
		require_once(app_path().'/Library/Wxpay/log.php');

    }
	
	function wxnativepayapi($info){
		
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($info['body']);
		$input->SetAttach($info['attach']);
		$input->SetOut_trade_no($info['out_trade_no']);
		$input->SetTotal_fee($info['total_fee']);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis",time()+600));
		$input->SetGoods_tag($info['tag']);
		$input->SetNotify_url($info['notifyurl']);
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id($info['productid']);
		
		$result = $this->GetPayUrl($input);
		$url = $result["code_url"];
		return $url;
	}
	
	/**
	 * 生成扫描支付URL,模式一
	 */
	public function GetPrePayUrl($productId){
		$biz = new \WxPayBizPayUrl();
		$biz->SetProduct_id($productId);
		$values = \WxpayApi::bizpayurl($biz);
		$url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
		return $url;
	}
	
	/**
	 * 参数数组转换为url参数
	 */
	private function ToUrlParams($urlObj){
		$buff = "";
		foreach ($urlObj as $k => $v){
			$buff .= $k . "=" . $v . "&";
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 */
	public function GetPayUrl($input){
		if($input->GetTrade_type() == "NATIVE"){
			$result = \WxPayApi::unifiedOrder($input);
			return $result;
		}
	}
}