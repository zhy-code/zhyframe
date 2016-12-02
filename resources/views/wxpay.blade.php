<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<title>充值系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" type="text/css" href="{{asset('home/css/common.css')}}"/>
<link rel="stylesheet" href="{{asset('home/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('home/js/iconfont/iconfont.css')}}">
<link rel="stylesheet" href="{{asset('home/css/style.css')}}">
<link rel="stylesheet" href="{{asset('home/css/css.css')}}">
</head>

<body>
<!-- advertise start -->
<div class="container">
    <div class="row">
    	<div class="En_adver">
        	<img src="{{asset('home/img/vip.jpg')}}">
        </div>
    </div>
</div>
<!-- advertise end -->

<!-- vip option start -->
<div class="container">
	<div class="row">
    	<div class="vipGold">
          <div class="vipGold_title"><span>充值套餐</span></div>
          <div class="vipGold_cont">
            <ul>
              <li onclick="choseviptc(this)">
                <div><span>20元</span>/1个月</div>
                <i class="iconfont">&#xe617;</i>
              </li>
              <li onclick="choseviptc(this)">
                <div><span>50元</span>/3个月</div>
                <i class="iconfont">&#xe617;</i>
              </li>
              <li onclick="choseviptc(this)">
                <div><span>80元</span>/半年</div>
                <i class="iconfont">&#xe617;</i>
              </li>
            </ul>
          </div>
        </div>
        <div class="vipDefray mt-15">
        	<div class="vipGold_title"><span>充值号码</span></div>
          	<div class="vipDefray_cont WW90">
                <input type="text" name="chargecode" placeholder="请输入充值号码" class="form-control H40">
            </div>
        </div>
        <div class="ZF" onclick="callpay()"><a href="javascript:;">去支付</a></div>
    </div>
</div>
<!-- vip option end -->

<!--所有页面都用 开始-->
<script type="text/javascript" src="{{asset('home/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('home/js/bootstrap.min.js')}}"></script>
<!--所有页面都用 结束-->
<!-- 勾选 -->
<script>
function choseviptc(obj){
	$(obj).children('div').css('border-color','#e5004f');
	$(obj).children('i').css('display','block')
	$(obj).siblings().children('div').css('border-color','#ebebeb');
	$(obj).siblings().children('i').css('display','none');
}
</script>
<script type="text/javascript">
//调用微信JS api 支付
function jsApiCall(){
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		{!!$jsApiParameters!!},
		function(res){
			WeixinJSBridge.log(res.err_msg);
			//alert(res.err_code+res.err_desc+res.err_msg);
		}
	);
}

function callpay(){
	if (typeof WeixinJSBridge == "undefined"){
		if( document.addEventListener ){
			document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		}else if (document.attachEvent){
			document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		}
	}else{
		jsApiCall();
	}
}
</script>
</body>
</html>
