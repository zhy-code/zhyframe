@extends('admin.common.zhyframe')

@section('head')
@endsection

@section('content')
<div class="container mt-50">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="sortserviceInfoForm">
				{{ csrf_field()}}
				<div class="form-group">
					<label class="col-sm-4 control-label">归属商铺类别：</label>
					<div class="col-sm-6">
						<select class="form-control" name="sortservice_shop_id">
							<option>请选择</option>
							@foreach($sortserviceshoplist as $sortserviceshop)
							<option value="{{$sortserviceshop->sortserviceshop_id}}" @if($sortserviceinfo->sortservice_shop_id == $sortserviceshop->sortserviceshop_id) selected @endif>{{$sortserviceshop->sortserviceshop_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">分类归属：</label>
					<div class="col-sm-6">
						<select class="form-control" name="sortservice_parent_id">
							<option>请选择</option>
							<option value="0" @if($sortserviceinfo->sortservice_parent_id == 0) selected @endif>初始级分类</option>
							@if(count($sortservicelist))
								{!!$sortservicelist!!}
							@endif
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">分类名称：</label>
					<div class="col-sm-6">
						<input name="sortservice_name" class="form-control" type="text" value="{{$sortserviceinfo->sortservice_name}}">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">排序：</label>
					<div class="col-sm-6">
						<input name="sortservice_sort" class="form-control" type="text" value="{{$sortserviceinfo->sortservice_sort}}">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">备注：</label>
					<div class="col-sm-6">
						<input name="sortservice_remark" class="form-control" type="text" value="{{$sortserviceinfo->sortservice_remark}}">
					</div>
				</div>
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="layAjaxForm($('#sortserviceInfoForm').serialize(), '/admin/sortservice/sortserviceeditsave/{{$sortserviceinfo->sortservice_id}}', 'post')">保&nbsp;&nbsp;存</span>
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