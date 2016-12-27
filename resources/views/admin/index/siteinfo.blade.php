@extends('admin.common.zhyframe')

@section('head')
@endsection

@section('content')
<div class="wrapper mt-25">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="siteInfoForm">
				{{ csrf_field() }}
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th colspan="4">网站基本配置</th>
						</tr>
					</thead>
					<tr>
						<td class="text-right WW15">网站名称：</td>
						<td><input type="text" value="@if($siteinfo){{$siteinfo->site_name}}@endif" name="site_name" class="form-control WW100"></td>
						<td class="text-right WW15">负责人名称：</td>
						<td><input type="text" value="@if($siteinfo){{$siteinfo->site_manager}}@endif" name="site_manager" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right WW15">网站关键字：</td>
						<td colspan="3"><input type="text" value="@if($siteinfo){{$siteinfo->site_keyword}}@endif" name="site_keyword" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right">网站描述：</td>
						<td colspan="3"><textarea name="site_description" class="form-control" rows="4">@if($siteinfo){{$siteinfo->site_description}}@endif</textarea></td>
					</tr>
					<tr>
						<td class="text-right">企业邮箱：</td>
						<td colspan="3"><input type="text" value="@if($siteinfo){{$siteinfo->mail}}@endif" name="mail" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right">版权信息：</td>
						<td colspan="3"><input type="text" value="@if($siteinfo){{$siteinfo->copyright}}@endif" name="copyright" class="form-control WW100"></td>
					</tr>
				</table>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th colspan="4">联系信息设置<small class="ml-10">（若是多个，请用 “ | ” 隔开）</small></th>
						</tr>
					</thead>
					<tr>
						<td class="text-right WW15">联系电话：</td>
						<td colspan="3"><input type="text" value="@if($siteinfo){{$siteinfo->contact_phone}}@endif" name="contact_phone" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right">联系QQ：</td>
						<td colspan="3"><input type="text" value="@if($siteinfo){{$siteinfo->contact_qq}}@endif" name="contact_qq" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right">联系人：</td>
						<td colspan="3"><input type="text" value="@if($siteinfo){{$siteinfo->contact_person}}@endif" name="contact_person" class="form-control WW100"></td>
					</tr>
					<tr>
						<td class="text-right">联系地址：</td>
						<td colspan="3"><input type="text" value="@if($siteinfo){{$siteinfo->contact_address}}@endif" name="contact_address" class="form-control WW100"></td>
					</tr>
				</table>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th colspan="4">图片配置</th>
						</tr>
					</thead>
					<tr>
						<td class="text-right WW15">网站site_logo：</td>
						<td>
							<span class="help-block m-b-none" id="LastImgBtn_A">
								<img src="@if(isset($siteinfo->site_logo)){{ asset($siteinfo->site_logo)}}@else{{asset('img/nopic.jpg')}}@endif" class="W200 file-select-image">
								<input type="file" style="display:none;" onchange="picload(event,'500','0.95','LastImgBtn_A','site_logo')" />
								<input type="hidden" id="site_logo" name="site_logo" value="@if($siteinfo){{$siteinfo->site_logo}}@endif">
							</span>
						</td>
						<td class="text-right WW15">微信二维码：</td>
						<td>
							<span class="help-block m-b-none" id="LastImgBtn_B">
								<img src="@if(isset($siteinfo->wechat_logo)){{asset($siteinfo->wechat_logo)}}@else{{asset('img/nopic.jpg')}}@endif" class="W200 file-select-image">
								<input type="file" style="display:none;" onchange="picload(event,'500','0.95','LastImgBtn_B','wechat_logo')" />
								<input type="hidden" id="wechat_logo" name="wechat_logo" value="@if($siteinfo){{$siteinfo->wechat_logo}}@endif">
							</span>
						</td>
					</tr>
				</table>
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="layAjaxForm($('#siteInfoForm').serialize(), '/admin/index/siteinfo', 'post')">保&nbsp;&nbsp;存</span>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script src="{{asset('js/public.js')}}"></script>
<script src="{{asset('js/plugins/zhypic/uploadpic.js') }}"></script>
@endsection