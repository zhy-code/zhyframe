@extends('admin.common.zhyframe')

@section('head')
@endsection

@section('content')
<div class="container mt-50">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="menuInfoForm">
				{{ csrf_field()}}
				<div class="form-group">
					<label class="col-sm-4 control-label">菜单归属：</label>
					<div class="col-sm-6">
						<select class="form-control" name="menu_parent_id">
							<option>请选择</option>
							<option value="0">一级菜单</option>
							@foreach($menulist as $key => $menu)
							<option value="{{$menu->menu_id}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|—— {{$menu->menu_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">菜单名称：</label>
					<div class="col-sm-6">
						<input name="menu_name" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">模块名称（Module）：</label>
					<div class="col-sm-6">
						<input name="menu_module" value="Admin" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">控制器名称（Controller）：</label>
					<div class="col-sm-6">
						<input name="menu_controller" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">操作名称（Action）：</label>
					<div class="col-sm-6">
						<input name="menu_action" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">额外参数（Parameter）：</label>
					<div class="col-sm-6">
						<input name="menu_parameter" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">图标：</label>
					<div class="col-sm-6">
						<input name="menu_icon" class="form-control WW80" type="text" placeHolder="一级菜单需要图标名称，其他的可不填写" style="display:inline">
						<span class="pull-right mt-5"><a href="/fontawesome.html" target="_blank">查看图标库</a></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">排序：</label>
					<div class="col-sm-6">
						<input name="menu_sort" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">备注：</label>
					<div class="col-sm-6">
						<input name="menu_remark" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="layAjaxForm($('#menuInfoForm').serialize(), '/admin/menu/menuaddsave', 'post')">保&nbsp;&nbsp;存</span>
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