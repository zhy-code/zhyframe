@extends('admin.common.zhyframe')

@section('head')
<meta name="csrf-token" content="{{csrf_token()}}">
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
			<h2>Banner 图管理</h2>
		</div>
		<div class="ibox-content">
			<div class="row row-lg">
				<div class="col-sm-12">
					<!-- Example Events -->
					<div class="example-wrap mb-15">
						<div class="btn-group hidden-xs" id="tableEventsToolbar" role="group">
							<button type="button" class="btn btn-outline btn-default mr-10" onclick="layOpenView('/admin/banner/banneradd','100%','100%','Banner 图添加')">
								<i class="fa fa-plus-square-o mr-5" aria-hidden="true"></i>添加 Banner 图
							</button>
							<select class="form-control" name="classify" onchange="selectRes(this)">
								<option value="0">全部</option>
								@foreach($classifylist as $v)
								<option value="{{$v}}" @if($v==$classify) selected @endif>{{$v}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<!-- End Example Events -->
					@foreach($bannerlist as $key => $banner)
					<div class="col-sm-3">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>【 {{$banner->banner_classify}} 】  {{$banner->banner_title}}</h5>
								<div class="ibox-tools">
									<a href="javascript:;" onclick="layOpenView('/admin/banner/banneredit/{{$banner->banner_id}}','100%','100%','编辑Banner图')">
										<i class="fa fa-wrench">  编辑  </i>
									</a>
								</div>
							</div>
							<div class="ibox-content">
								<div class="carousel slide" id="banner_{{$key}}">
									<div class="carousel-inner">
										@foreach($banner->banner_url_format as $k => $pic)
										<div class="item @if($k==0) active @endif">
											<img alt="image" class="img-responsive" src="{{asset($pic)}}">
										</div>
										@endforeach
									</div>
									@if(count($banner->banner_url_format) > 1)
									<a data-slide="prev" href="#banner_{{$key}}" class="left carousel-control">
										<span class="icon-prev"></span>
									</a>
									<a data-slide="next" href="#banner_{{$key}}" class="right carousel-control">
										<span class="icon-next"></span>
									</a>
									@endif
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
    </div>
</div>
@endsection

@section('footer')
<script src="{{asset('js/public.js')}}"></script>
<script>
function selectRes(obj){
	var val =  $(obj).val();
	if(val){
		location.href = '/admin/banner/bannerlist/'+val;
	}
}
</script>
@endsection