@extends('admin.common.zhyframe')

@section('head')
<link href="{{asset('css/login.min.css')}}" rel="stylesheet">
@endsection

@section('content')

<body class="signin">
	<div class="row">
		<div class="col-sm-4">
		</div>
		<div class="col-sm-4 login-top">
			<form id="loginForm">
				{{ csrf_field() }}
				<div class="form-group ">
					<h1 class="no-margins">后台管理系统</h1>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="user_name" placeholder="请输入用户名" onkeydown="EnterPress()" />
				</div>
				<div class="form-group">
					<input type="password" class="form-control"  name="user_password" placeholder="请输入密码" onkeydown="EnterPress()" />
				</div>
			</form>
			
			<button class="btn btn-success btn-block" onclick="sendForm('/admin/login')" id="loginBtn">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
			
			<div class="signup-footer">
			<div style="float:right">
				&copy; Copyright 雪霁互联网技术开发
			</div>
		</div>
		</div>
	</div>
@endsection

@section('footer')
<script type="text/javascript" src="{{asset('js/jquery.md5.js')}}"></script>
<script type="text/javascript" src="{{asset('js/public.js')}}"></script>
<script>
/** 键盘回车登陆 **/
function EnterPress(){ 
	var e = e || window.event;
	var code = e.which || e.keyCode;
	if(code == 13){
		$('#loginBtn').trigger('click');
	}
}

function sendForm(url){
	//密码加密
	elementEncry("input[name='user_password']");
	var parameter = $('#loginForm').serialize();
	layAjaxForm(parameter, url, 'post');
}
</script>

@endsection