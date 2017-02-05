@extends('admin.common.zhyframe')

@section('head')
<link href="{{asset('js/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('js/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-50">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="bannerInfoForm">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="col-sm-2 control-label">banner名称：</label>
					<div class="col-sm-8">
						<p class="form-control-static">{{$bannerinfo->banner_title}}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">banner位置：</label>
					<div class="col-sm-8">
						<p class="form-control-static">{{$bannerinfo->banner_classify}}</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">banner备注：</label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="3" name="banner_remark">{{$bannerinfo->banner_remark}}</textarea>
					</div>
				</div>
				@foreach($bannerinfo->banner_url_format as $key => $banner_url)
				<div class="form-group addbanner">
					<label class="col-sm-2 control-label">@if($key==0)banner图集：@endif</label>
					<div class="col-sm-3">
						<span class="help-block m-b-none" id="LastImgBtn_{$key}">
							<img src="{{asset($banner_url)}}" class="W200 file-select-image">
							<input type="file" style="display:none;" onchange="picload(event,'1200','0.95','LastImgBtn_0','banner_url[]')" />
							<input type="hidden" name="banner_url[{{$key}}]" value="{{$banner_url}}">
						</span>
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control mt-50" name="link_url[]" placeHolder="此处填写 banner 链接，不需要则不填" value="{{$bannerinfo->link_url_format[$key]}}">
					</div>
					<div class="col-sm-1">
						@if($key==0)
						<span class="btn btn-white mt-50" onclick="addBanner()">增加</span>
						@else
						<span class="btn btn-white mt-50" onclick="removeBanner(this)">删除</span>
						@endif
					</div>
				</div>
				@endforeach
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="sendForm($('#bannerInfoForm').serializeArray(), '/admin/banner/bannereditsave/{{$bannerinfo->banner_id}}')">保&nbsp;&nbsp;存</span>
						<span class="btn btn-white ml-15" onclick="layClose()">取&nbsp;&nbsp;消</span>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
<script type="text/html" id="add_banner">

<div class="form-group addbanner">
	<label class="col-sm-2 control-label"></label>
	<div class="col-sm-3">
		<span class="help-block m-b-none" id="LastImgBtn_X">
			<img src="{{asset('img/nopic.jpg')}}" class="W200" onclick="openfile(this)">
			<input type="file" style="display:none;" onchange="picload(event,'1200','0.95','LastImgBtn_X','banner_url[]')" />
		</span>
	</div>
	<div class="col-sm-4">
		<input type="text" class="form-control mt-50" name="link_url[]" placeHolder="此处填写 banner 链接，不需要则不填">
	</div>
	<div class="col-sm-1">
		<span class="btn btn-white mt-50" onclick="removeBanner(this)">删除</span>
	</div>
</div>
</script>
@section('footer')
<script src="{{asset('js/public.js')}}"></script>
<script src="{{ asset('js/plugins/zhypic/uploadpic.js') }}"></script>

<script>
function sendForm(formdata, url){
	$('[id^=editor_content_').each(function(){
		var str = this.id.substr(15);
		formdata.push({"name":str,"value":$(this).code()});
	});
	//console.log(formdata);
	layAjaxForm(formdata, url, 'post');
}
</script>

<script>
function addBanner(){
	//计算已有个数
	var bannernum = $('.addbanner').length;
	var htmlstr = $('#add_banner').html();
	var reg = new RegExp("LastImgBtn_X","g"); //创建正则RegExp对象  
	htmlstr = htmlstr.replace(reg,"LastImgBtn_"+bannernum);
	$('.addbanner').last().after(htmlstr);
}
//触发打开文件选择框
function openfile(obj){
	$(obj).next('input[type="file"]').click();
}
function removeBanner(obj){
	$(obj).parent().parent().remove();
}
</script>

@endsection