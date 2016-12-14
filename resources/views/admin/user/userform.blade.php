@extends('admin.common.zhyframe')

@section('head')
<link href="{{asset('js/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('js/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-50">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="userInfoForm">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="col-sm-2 control-label">登陆账号：</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="user_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label ftz-20">登陆密码：</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" placeholder="请设置登陆密码" name="user_password">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">管理员名称：</label>
					<div class="col-sm-8">
						<input type="text" placeholder="请输入管理员名称" class="form-control" name="user_true_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">备注信息：</label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="3" name="user_remark"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-title">
                        编辑/保存为html代码示例
                        <button id="edit" class="btn btn-white" onclick="edit('#editor_demo')" type="button">编辑</button>
                        <button id="save" class="btn btn-white" onclick="save('#editor_demo')" type="button">预览</button>
                    </div>
                    <div class="ibox-content">
                        <div class="wrapper" id="editor_demo">
                            
                        </div>
                    </div>
                </div>
            </div>
				</div>
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="layAjaxForm($('#userInfoForm').serialize(), '/admin/user/useraddsave', 'post')">保&nbsp;&nbsp;存</span>
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
<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote.min.js')}}"></script>
<script src="{{asset('js/plugins/summernote/summernote-zh-CN.js')}}"></script>
<script>
	$(document).ready(function(){  
		$('#editor_demo').summernote({
			lang: 'zh-CN',
			focus: true,
			onImageUpload: function(files) {
				sendFile('#editor_demo', files[0]);  
			}
		});
	});
	var edit = function (obj) {
		$(obj).summernote({
			lang: 'zh-CN',
			focus: true,
			callbacks: {  
				onImageUpload: function(files) {
					img = sendFile(obj, files[0]);  
				}
			}
		});
	};
	var save = function (obj) {
		var aHTML = $(obj).code(); //save HTML If you need(aHTML: array).
		$(obj).destroy();
	};
		
	function sendFile(obj,file) {  
		data = new FormData();  
		data.append("file", file);  
		console.log(data); 
		alert(data);
		$.ajax({  
			data: data,  
			type: "POST",  
			url: "{:U('Test/upload')}",  
			cache: false,  
			contentType: false,  
			processData: false,  
			success: function(url) {  
				  $(obj).summernote('insertImage', url, 'image name'); // the insertImage API  
			}  
		});  
	}  
</script>
@endsection