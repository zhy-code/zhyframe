@extends('admin.common.zhyframe')

@section('head')
<meta name="csrf-token" content="{{csrf_token()}}">
<link href="{{asset('js/plugins/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<style>
table thead tr th{
	text-align:center;
}
table tbody tr td{
	text-align:center;
}
</style>
<body style="font-size:16px;">
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h2>管理员列表</h2>
		</div>
		<div class="ibox-content">
			<div class="row row-lg">
				<div class="col-sm-12">
					<!-- Example Events -->
					<div class="example-wrap">
						<div class="example">
							<div class="btn-group hidden-xs" id="tableEventsToolbar" role="group">
								<button type="button" class="btn btn-outline btn-default mr-10">
									<i class="fa fa-plus-square-o mr-5" aria-hidden="true"></i>添加管理员
								</button>
								<button type="button" class="btn btn-outline btn-default">
									<i class="fa fa-trash-o mr-5" aria-hidden="true"></i>批量删除
								</button>
							</div>
							<table id="tableEvents" data-height="400" data-mobile-responsive="true">
								<thead>
									<tr>
										<th data-field="user_checkbox"><label><input name="checkboxAll" type="checkbox" class="input-checkbox" onclick="checkChose()"><i>✓</i></label></th>
										<th data-field="user_name">管理员账号</th>
										<th data-field="user_status_format">管理员状态</th>
										<th data-field="user_last_login_time_format">最后登录的时间</th>
										<th data-field="user_last_login_ip">最后登录的IP</th>
										<th data-field="user_operation">操作</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<!-- End Example Events -->
				</div>
			</div>
		</div>
    </div>
</div>
<form id="userDelForm">
	<input type="hidden" name="_method" value="delete">
	<input type="hidden" name="id" id="delid">
</form>
@endsection

@section('footer')
<!-- Bootstrap table -->
<script src="{{asset('js/plugins/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script src="{{asset('js/plugins/bootstrap-table/bootstrap-table-zh-CN.min.js')}}"></script>
<script src="{{asset('js/public.js')}}"></script>
<script>
var datalist = {!!$userlist!!};
(function(document, window, $) {
	'use strict';
	(function() {
		$('#tableEvents').bootstrapTable({
			data: datalist,
			search: true,
			pagination: true,
			showRefresh: true,
			showToggle: true,
			showColumns: true,
			iconSize: 'outline',
			toolbar: '#tableEventsToolbar',
			icons: {
				refresh: 'fa fa-refresh',
				toggle: 'fa fa-list-alt',
				columns: 'fa fa-list'
			}
		});
	})();
})(document, window, jQuery);
</script>
@endsection