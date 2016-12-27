@extends('admin.common.zhyframe')

@section('head')
<link href="{{asset('js/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('js/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-50">
	<div class="row">
		<div class="col-sm-12">
			<form class="form-horizontal" role="form" id="newsInfoForm">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="col-sm-2 control-label">新闻标题：</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="title">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">新闻封面图片：</label>
                    <div class="col-sm-3">
                        <span class="help-block m-b-none" id="LastImgBtn_A">
							<img src="{{asset('img/nopic.jpg')}}" class="WW100">
							<input type="hidden" id="title_pic" name="title_pic">
						</span>
                    </div>
					<div class="col-sm-4">
                        <button class="btn btn-white file-select-image mt-35" type="button"><i class="fa fa-image"></i>&nbsp;选择图片</button>
                        <input type="file" style="display:none;" onchange="picload(event,'500','0.95','LastImgBtn_A','title_pic')" />
                    </div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">作者：</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="author">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">来源：</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="origin">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">选择类别：</label>
					<div class="col-sm-8">
						<select class="form-control" name="classify">
							<option>请选择</option>
							<option value="1">集团新闻</option>
							<option value="2">车型动态</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">简要概述：</label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="3" name="brief"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">文章内容：</label>
					<span id="editor_control_details"><a href="javascript:;" onclick="edit('details')">编辑</a></span>
					<div class="col-sm-8">
						<div class="ibox-content" style="border-width:1px;border-style: solid;">
							<div class="wrapper" id="editor_content_details"></div>
						</div>
					</div>
				</div>
				<div class="form-group mt-50">
					<div class="col-sm-4 col-sm-offset-5 ">
						<span class="btn btn-primary" onclick="sendForm($('#newsInfoForm').serializeArray(), '/admin/news/newsaddsave')">保&nbsp;&nbsp;存</span>
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
<script src="{{ asset('js/plugins/zhypic/uploadpic.js') }}"></script>
<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote.min.js')}}"></script>
<script src="{{asset('js/plugins/summernote/summernote-zh-CN.js')}}"></script>
<script>
	var edit = function (name) {
		$('#editor_content_'+name).summernote({
			lang: 'zh-CN',
			focus: true,
			onImageUpload: function(files, editor, welEditable) {
				img = sendFile(files[0], editor, welEditable);  
			}
		});
		//改变操作键
		$('#editor_control_'+name).empty().html('<a href="javascript:;" onclick="save(\''+name+'\')">预览</a>');
	};
	var save = function (name) {
		var aHTML = $('#editor_content_'+name).code();
		$('#editor_content_'+name).destroy();
		//改变操作键
		$('#editor_control_'+name).empty().html('<a href="javascript:;" onclick="edit(\''+name+'\')">编辑</a>');
	};
	
	function sendFile(file, editor, welEditable) {  
		data = new FormData();  
		data.append("file", file);  
		console.log(data);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').val()
			},
			data: data,  
			type: "POST",  
			url: "/editor-uploads",
			cache: false,  
			contentType: false,  
			processData: false,  
			success: function(data) {
				if(data.status>0){
					editor.insertImage(welEditable, data.url);
				}
			}  
		});  
	}  
</script>

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

@endsection