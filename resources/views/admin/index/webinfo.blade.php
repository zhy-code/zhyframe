@extends('admin.common.zhyframe')

@section('head')
@endsection

@section('content')
<div class="wrapper mt-25">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="webInfoForm">
				{{ csrf_field() }}
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th colspan="4">网站基本配置</th>
						</tr>
					</thead>
					<tr>
						<td class="text-right">网站名称：</td>
						<td><input type="text" value="{{$webinfo->web_name}}" name="web_name" class="form-control WW100"></td>
						<td class="text-right">负责人名称：</td>
						<td><input type="text" value="{{$webinfo->hoster}}" name="hoster" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right">工作地址：</td>
						<td colspan="3"><input type="text" value="{{$webinfo->web_address}}" name="web_address" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right">网站关键字：</td>
						<td colspan="3"><input type="text" value="{{$webinfo->keyword}}" name="keyword" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right">网站描述：</td>
						<td colspan="3"><textarea name="description" class="form-control" rows="4">{{$webinfo->description}}</textarea></td>
					</tr>
				</table>
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="layAjaxForm($('#webInfoForm').serialize(), '/admin/index/webinfo', 'post')">保&nbsp;&nbsp;存</span>
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