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
			<h2>菜单列表</h2>
		</div>
		<div class="ibox-content">
			<div id="treeview" class="test"></div>
		</div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{asset('js/plugins/bootstrap-treeview/bootstrap-treeview.js')}}"></script>
<script src="{{asset('js/public.js')}}"></script>
<script>
	$(function () {

		var json = {!! $menulist !!};

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