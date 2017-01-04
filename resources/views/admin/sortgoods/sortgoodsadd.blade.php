@extends('admin.common.zhyframe')

@section('head')
@endsection

@section('content')
<div class="container mt-50">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="sortgoodsInfoForm">
				{{ csrf_field()}}
				<div class="form-group">
					<label class="col-sm-4 control-label">归属商铺类别：</label>
					<div class="col-sm-6">
						<select class="form-control" name="sortgoods_shop_id">
							<option>请选择</option>
							@foreach($sortgoodsshoplist as $sortgoodsshop)
							<option value="{{$sortgoodsshop->sortgoodsshop_id}}">{{$sortgoodsshop->sortgoodsshop_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">分类归属：</label>
					<div class="col-sm-6">
						<select class="form-control" name="sortgoods_parent_id">
							<option>请选择</option>
							<option value="0">初始级分类</option>
							@if(count($sortgoodslist))
								{!!$sortgoodslist!!}
							@endif
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">分类名称：</label>
					<div class="col-sm-6">
						<input name="sortgoods_name" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">排序：</label>
					<div class="col-sm-6">
						<input name="sortgoods_sort" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">备注：</label>
					<div class="col-sm-6">
						<input name="sortgoods_remark" class="form-control" type="text">
					</div>
				</div>
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="layAjaxForm($('#sortgoodsInfoForm').serialize(), '/admin/sortgoods/sortgoodsaddsave', 'post')">保&nbsp;&nbsp;存</span>
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