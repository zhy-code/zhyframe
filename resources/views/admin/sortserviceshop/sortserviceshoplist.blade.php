@extends('admin.common.zhyframe')

@section('head')
<meta name="csrf-token" content="{{csrf_token()}}">
<link href="{{asset('js/plugins/bootstrap-treeview/bootstrap-treeview.css')}}" rel="stylesheet">
@endsection

@section('content')
<body class="font16">
<div class="wrapper animated fadeInRight">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h2>
				服务商铺分类列表
				<button type="button" class="btn btn-outline btn-default pull-right" onclick="layOpenView('/admin/sortserviceshop/sortserviceshopadd','90%','90%','服务商铺分类添加')">
					<i class="fa fa-plus-square-o mr-5" aria-hidden="true"></i>添加服务商铺分类
				</button>
			</h2>
		</div>
		<div class="ibox-content">
			<div id="treeview" class="test"></div>
		</div>
    </div>
</div>
<form id="delForm">
	<input type="hidden" name="_method" value="delete">
	<input type="hidden" name="id" id="delid">
</form>
@endsection

@section('footer')
<script src="{{asset('js/plugins/bootstrap-treeview/bootstrap-treeview.js')}}"></script>
<script src="{{asset('js/public.js')}}"></script>
<script>
	$(function () {

		var json = {!! $sortserviceshoplist !!};

		$('#treeview').treeview({
			levels: 1,
			expandIcon: "fa fa-folder",
			collapseIcon: "fa fa-folder-open",
			nodeIcon: "fa fa-file-word-o",
			enableLinks: false,
			showBorder: true,
			showTags: true,
			highlightSelected: true,
			//color: "yellow",
			//backColor: "purple",
			//onhoverColor: "orange",
			//borderColor: "red",
			//selectedColor: "yellow",
			//selectedBackColor: "darkorange",
			/*
			onNodeSelected: function (event, node) {
				$('#event_output').prepend('<p>您单击了 ' + node.text + '</p>');
			},
			*/
			data: json
		});
	});
</script>
@endsection