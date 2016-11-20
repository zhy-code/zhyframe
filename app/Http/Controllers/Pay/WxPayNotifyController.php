<?php
namespace Home\Controller;

header("Content-type:text/html;charset=utf-8");
//微信支付API
import('Vendor.Wxpay.lib.WxPayConfig','','.php');
import('Vendor.Wxpay.lib.WxPayData','','.php');
import('Vendor.Wxpay.lib.WxPayException','','.php');
import('Vendor.Wxpay.lib.WxPayNotify','','.php');
import('Vendor.Wxpay.lib.WxPayApi','','.php');
import('Vendor.Wxpay.log','','.php');


class WxPayNotifyController extends \WxPayNotify {
	
	//重写回调处理函数
	public function NotifyProcess($data,&$msg){
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		
		//根据 $data["out_trade_no"] 订单号 更新订单状态
		$re = $this->wxpayend($data["out_trade_no"]);
		
		if($re){
			return true;
		}else{
			$msg = "订单状态异常！";
			return false;
		}
		
	}
	
	function wxnotify(){
		$this->Handle(false);
	}
	
	/**
	 * 订单号 更新订单状态的函数
	 * 结果一定要返回 true / false
	 */
	function wxpayend($out_trade_no){
		
		
		if($result){
			return true;
		}else{
			return false;
		}
	}
}