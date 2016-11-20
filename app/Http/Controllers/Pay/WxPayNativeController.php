<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 刷卡支付实现类
 */
class WxPayNativeController extends Controller {
	
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
		//微信支付API
		import('Vendor.Wxpay.lib.WxPayConfig','','.php');
		import('Vendor.Wxpay.lib.WxPayData','','.php');
		import('Vendor.Wxpay.lib.WxPayException','','.php');
		import('Vendor.Wxpay.lib.WxPayNotify','','.php');
		import('Vendor.Wxpay.lib.WxPayApi','','.php');
		import('Vendor.Wxpay.log','','.php');
    }
	
	function wxnativepayapi($info){
		
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($info['body']);
		$input->SetAttach($info['attach']);
		$input->SetOut_trade_no($info['order_sn']);
		$input->SetTotal_fee($info['price']);
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