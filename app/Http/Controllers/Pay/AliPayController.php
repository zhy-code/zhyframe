<?php

namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use Redirect;

class AliPayController extends Controller {
	
	public $ismoblie;
	
	public function __construct(){
		header("Content-type:text/html;charset=utf-8");
		//支付宝支付		
		require_once(app_path().'/Library/Alipay/alipayCore.php');
		require_once(app_path().'/Library/Alipay/alipayMd5.php');
		require_once(app_path().'/Library/Alipay/alipayNotify.php');
		require_once(app_path().'/Library/Alipay/alipaySubmit.php');
		
		$this->ismoblie = $this->isMobile();
    }
	
	/**
	 * 支付宝支付成功后 后续操作代码
	 * 此处为变更订单状态
	 */
	protected function alipayend($out_trade_no){
		
		//此处为变更订单状态业务逻辑
		$chargedata = [
			'isend' => 1,
		];
		$order_re = DB::table('charge')->where('pay_code',$out_trade_no)->update($chargedata);
		if($order_re){
			$order_info = DB::table('charge')->where('pay_code',$out_trade_no)->first();
			DB::table('driver')->where('id', $order_info->userid)->increment('account_money',$order_info->charge_money);
		}
	}
	
	/** 
	 * 判断订单状态变更成功与否
	 * 是返回 True，否则返回 False 
	 * 【必要】 
	 */
	protected function returnRes($out_trade_no){
		
		//判断该笔订单是否在商户网站中已经做过处理,以下只是实例
		$order = DB::table('charge')->where('pay_code',$out_trade_no)->first();
		$ispay = $order->isend;
		
		if($ispay == 1){
			return true;
		}else{
			return false;	
		}
	}
	
	/**
	 * 支付宝支付后 跳转地址
	 * 【全域名】
	 */
	protected function acturl(){		
		$payset = DB::table('payinfo')->first();
		$root_url = $payset->alipayweb;	
		//支付成功后跳转地址
		$successpage = $root_url.'/alipay-success';
		//支付失败后跳转地址
		$error_notify_url = $root_url.'/alipay-failure';
		
		$acturl = array(
			'successpage'	=> $successpage,
			'error_notify_url' => $error_notify_url
		);
		return $acturl;
	}
	
	/**
	 * 支付宝配置信息
	 */
	protected function getAliInfo(){
		
		$payset = DB::table('payinfo')->first();
		$root_url = $payset->alipayweb;
		
		if($this->ismoblie){
			$service_type = "alipay.wap.create.direct.pay.by.user";	
		}else{		
			$service_type = "create_direct_pay_by_user";		
		}
		$alipay_config = array(			
			'partner'		=> $payset->alipartner,
			'key'			=> $payset->alikey,
			'seller_id'		=> $payset->alipartner,
			'sign_type'		=> strtoupper('MD5'),
			'input_charset'	=> strtolower('utf-8'),
			'cacert'    	=> getcwd().'\\cacert.pem',
			'transport'		=> 'http',
			'payment_type'	=> '1',
			'service'		=> $service_type,
			'notify_url'	=> $root_url.'/alipay-notify',
			'return_url'	=> $root_url.'/alipay-return',
		);
		return $alipay_config;
	}
	
	/**
	 * alipay支付接口 
	 */
	public function alipayapi($info){	
		$alipay_config	= $this->getAliInfo();
        $out_trade_no	= $info['out_trade_no'];
        $subject		= $info['subject'];
        $total_fee		= $info['total_fee'];
		$body 			= $info['body'];
		$show_url 		= $info['showurl'];  //商品展示地址 通过支付页面的表单进行传递
		$alipaySubmit = new \AlipaySubmit($alipay_config);
        $exter_invoke_ip = \Request::getClientIp();
		//防钓鱼时间戳 若要使用请调用类文件submit中的query_timestamp函数
		$anti_phishing_key = "";
		//$anti_phishing_key = $alipaySubmit->query_timestamp();
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service"		=> $alipay_config['service'],
				"partner"		=> trim($alipay_config['partner']),
				"seller_id"  	=> $alipay_config['seller_id'],
				"payment_type"	=> $alipay_config['payment_type'],
				"notify_url"	=> $alipay_config['notify_url'],
				"return_url"	=> $alipay_config['return_url'],
				"out_trade_no"	=> $out_trade_no,
				"subject"		=> $subject,
				"total_fee"		=> $total_fee,
				"body"			=> $body,
				"_input_charset"=> trim(strtolower($alipay_config['input_charset']))
		);
		if($this->ismoblie){
			$parameter['show_url'] = $show_url;
			$parameter['app_pay'] = "Y";
		}else{		
			$parameter['anti_phishing_key'] = $anti_phishing_key;
			$parameter['exter_invoke_ip'] = $exter_invoke_ip;
		}
		//建立请求
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	
	/** 
	 * 页面跳转同步通知页面路径
	 */
	protected function returnurl(){
		$alipay_config	= $this->getAliInfo();
		$alipayNotify	= new \AlipayNotify($alipay_config);
		$verify_result	= $alipayNotify->verifyReturn();	
		if($verify_result){
			$out_trade_no = $_GET['out_trade_no'];
			$trade_no = $_GET['trade_no'];
			$trade_status = $_GET['trade_status'];
		    if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
				//判断订单是否在商户网站中已经做过处理
				$re = $this->returnRes($out_trade_no);
				$acturl = $this->acturl();
				if($re){
					return redirect($acturl['successpage']);
				}else{
					echo '支付异常，请联系网站客服或管理员。（需提供当前订单号【'.$out_trade_no.'】和支付宝交易号【'.$trade_no.'】）';		
				}  
			}else {
				return redirect($acturl['errorpage']);
		    }
		}
		else {
		    echo "无法接收通知！（身份验证失败，可能是客服端网络异常）";
		}
	}
	
	/** 
	 * 服务器异步通知页面路径
	 */
	protected function notifyurl(){
		$alipay_config = $this->getAliInfo();
		$alipayNotify	= new \AlipayNotify($alipay_config);
		$verify_result	= $alipayNotify->verifyNotify();
		if($verify_result) {
			$out_trade_no = $_POST['out_trade_no'];
			$trade_no = $_POST['trade_no'];
			$trade_status = $_POST['trade_status'];
		    if($trade_status == 'TRADE_FINISHED') {
				//交易成功且结束，不可再做任何操作 
		    }else if ($trade_status == 'TRADE_SUCCESS') {
				/** 支付成功后 后续操作代码 **/
				$this->alipayend($out_trade_no);
		    }
			echo "success";	
		}else{	    
		    echo "fail";
		}
	}
	
	/** 
	 * 判断 PC OR 移动
	 */
	protected function isMobile() {
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
		//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            //找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
		//脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
			$clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');
			//从HTTP_USER_AGENT中查找手机浏览器的关键字
            if(preg_match("/(".implode('|', $clientkeywords).")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
                return true;
            }
        }
        //协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])){
            // 如果只支持wml并且不支持html那一定是移动设备，如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }
}