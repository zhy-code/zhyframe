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
<div class="wrapper animated fadeInRight">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h2>新闻列表</h2>
		</div>
		<div class="ibox-content">
			<div class="row row-lg">
				<div class="col-sm-12">
					<!-- Example Events -->
					<div class="example-wrap">
						<div class="btn-group hidden-xs" id="tableEventsToolbar" role="group">
							<button type="button" class="btn btn-outline btn-default mr-10" onclick="layOpenView('/admin/news/newsadd','100%','100%','新闻信息添加')">
								<i class="fa fa-plus-square-o mr-5" aria-hidden="true"></i>添加新闻
							</button>
							<button type="button" class="btn btn-outline btn-default" onclick="layListMultiDel('/admin/news/destroy')">
								<i class="fa fa-trash-o mr-5" aria-hidden="true"></i>批量删除
							</button>
						</div>
						<table id="tableEvents" data-height="auto" data-mobile-responsive="true">
							<thead>
								<tr>
									<th data-field="checkbox">
										<label>
											<input name="checkboxAll" type="checkbox" class="input-checkbox" onclick="checkChose()"><i>✓</i>
										</label>
									</th>
									<th data-field="title">新闻标题</th>
									<th data-field="author">新闻作者</th>
									<th data-field="origin">新闻来源</th>
									<th data-field="classify_format">新闻分类</th>
									<th data-field="status_format">新闻状态</th>
									<th data-field="edit_time_format">最后修改的时间</th>
									<th data-field="operation">操作</th>
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
<form id="delForm">
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
var datalist = {!!$newslist!!};
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