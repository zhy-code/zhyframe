@extends('admin.common.zhyframe')

@section('head')
@endsection

@section('content')
<div class="container mt-50">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="userInfoForm">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="col-sm-2 control-label">登陆账号：</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" readonly value="{{$userinfo->user_name}}">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label ftz-20">登陆密码：</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" placeholder="请设置登陆密码" name="user_password" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">管理员名称：</label>
					<div class="col-sm-8">
						<input type="text" placeholder="请输入管理员名称" class="form-control" name="user_true_name" value="{{$userinfo->user_true_name}}">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">备注信息：</label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="3" name="user_remark">{{$userinfo->user_remark}}</textarea>
					</div>
				</div>
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="layAjaxForm($('#userInfoForm').serialize(), '/admin/user/usereditsave/{{$userinfo->user_id}}', 'post')">保&nbsp;&nbsp;存</span>
						<span class="btn btn-white ml-15" onclick="layClose()">取&nbsp;&nbsp;消</span>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script src="{{asset('js/public.js')}}"></script>
@endsection