<?php
namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Redirect;

//微信支付API
require_once(app_path().'/Library/Wxpay/lib/WxPayConfig.php');
require_once(app_path().'/Library/Wxpay/lib/WxPayData.php');
require_once(app_path().'/Library/Wxpay/lib/WxPayException.php');
require_once(app_path().'/Library/Wxpay/lib/WxPayNotify.php');
require_once(app_path().'/Library/Wxpay/lib/WxPayApi.php');
require_once(app_path().'/Library/Wxpay/log.php');


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
		
		//此处为变更订单状态业务逻辑
		$chargedata = [
			'isend' => 1,
		];
		$order_re = DB::table('charge')->where('pay_code',$out_trade_no)->update($chargedata);
		if($order_re){
			$order_info = DB::table('charge')->where('pay_code',$out_trade_no)->first();
			DB::table('driver')->where('id', $order_info->userid)->increment('account_money',$order_info->charge_money);
		}
		if($order_re){
			return true;
		}else{
			return false;
		}
	}
}