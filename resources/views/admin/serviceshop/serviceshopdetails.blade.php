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
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox-content p-xl">
				<div class="row">
					<div class="col-sm-12">
						<h2>订单编号：<span class="text-navy">{{$serviceshopinfo->serviceshop_id}}</span></h2>
					</div>
				</div>
				<div class="table-responsive m-t">
					<table class="table table-border table-bordered table-bg table-hover table-striped">
						<tbody>
							<tr class="text-center">
								<td><strong>套餐内容</strong></td>
								<td>{{$serviceshopinfo->serviceshop_remark}}</td>
								<td><strong>支付金额</strong></td>
								<td>￥ {{$serviceshopinfo->serviceshop_remark}}</td>
							</tr>
							<tr class="text-center">
								<td><strong>充值类型</strong></td>
								<td>{{$serviceshopinfo->serviceshop_remark}}</td>
								<td><strong>充值状态</strong></td>
								<td> {{$serviceshopinfo->serviceshop_status_format}}</td>
							</tr>
							<tr class="text-center">
								<td><strong>支付日期</strong></td>
								<td>{{$serviceshopinfo->serviceshop_add_time_format}}</td>
								<td><strong>确认日期</strong></td>
								<td> {{$serviceshopinfo->serviceshop_confirm_time_format}}</td>
							</tr>
							<tr class="text-center">
								<td><strong>购买人姓名</strong></td>
								<td>{{$serviceshopinfo->serviceshop_remark}}</td>
								<td><strong>购买人联系方式</strong></td>
								<td> {{$serviceshopinfo->serviceshop_remark}}</td>
							</tr>
							
							<tr><td colspan="4"></td></tr>
							<tr class="text-center">
								<td><strong>身份证照片正面</strong></td>
								<td><img style="width:200px;" src="{{asset($serviceshopinfo->serviceshop_remark)}}" /></td>
								<td><strong>身份证照片反面</strong></td>
								<td><img style="width:200px;" src="{{asset($serviceshopinfo->serviceshop_remark)}}" /></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('footer')
<!-- Bootstrap table -->
<script src="{{asset('js/plugins/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script src="{{asset('js/plugins/bootstrap-table/bootstrap-table-zh-CN.min.js')}}"></script>
<script src="{{asset('js/public.js')}}"></script>
@endsection