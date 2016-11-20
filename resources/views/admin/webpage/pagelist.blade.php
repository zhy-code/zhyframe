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
<body class="font16">
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h2>网站页面列表</h2>
		</div>
		<div class="ibox-content">
			<div class="row row-lg">
				<div class="col-sm-12">
					<div class="example-wrap">
						<div class="btn-group hidden-xs" id="tableEventsToolbar" role="group">
							<button type="button" class="btn btn-outline btn-default mr-10" onclick="layOpenView('/admin/user/useradd','90%','90%','管理员信息添加')">
								<i class="fa fa-plus-square-o mr-5" aria-hidden="true"></i>添加网站页面
							</button>
						</div>
						<table id="tableEvents" data-height="auto" data-mobile-responsive="true">
							<thead>
								<tr>
									<th data-field="user_name">页面名称</th>
									<th data-field="user_name">点击量</th>
									<th data-field="user_status_format">最后编辑时间</th>
									<th data-field="user_operation">操作</th>
								</tr>
							</thead>
						</table>
					</div>
					<!-- End Example Events -->
				</div>
			</div>
		</div>
    </div>
</div>
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
			showToggle: false,
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