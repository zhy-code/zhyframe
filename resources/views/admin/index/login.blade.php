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
			<form method="post" action="">
				<div class="form-group ">
					<h1 class="no-margins">后台管理系统</h1>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="user_name" placeholder="用户名" style="height:45px;border-radius:8px;font-size:16px;"/>
				</div>
				<div class="form-group">
					<input type="password" class="form-control"  name="user_password" placeholder="密码" style="height:45px;border-radius:8px;font-size:16px;"/>
				</div>
				<button class="btn btn-success btn-block" style="height:55px;border-radius:8px;font-size:25px;">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
			</form>
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
<script>

</script>

@endsection