var formStatus = false;

/**
 * 表单元素加密
 */
function elementEncry(obj){
	var val = $(obj).val();
	var valEncry = val ? $.md5(val) : val;
	$(obj).val(valEncry);
}

/**
 * 选择图片
 */
$('.file-select-image').click(function() {
	$(this).next('input[type="file"]').click();
});

/**
 * 全选/全不选
 */
function checkChose(){
	var statusall= $('[name="checkboxAll"]').prop('checked');
	if( statusall == true){
		//已勾选的去除勾选
		$('[name=checkboxList]').each(function(k,obj){
			$(obj).removeAttr('checked');
		});
		$('[name="checkboxAll"]').removeAttr('checked');
	}else{
		//未勾选的增加勾选
		$('[name=checkboxList]').each(function(k,obj){
			$(obj).prop('checked','checked');
		});
		$('[name="checkboxAll"]').prop('checked','checked');
	}
}

/**
 * layer-open
 * 使用layer打开链接页面
 */
function layOpenView(url, height, width, title){
	layer.open({
		type: 2,
		title: title,
		shadeClose: true,
		shade: 0.8,
		area: [width, height],
		content: url
	}); 
}

/**
 * layer-close
 * 关闭 layer 弹框
 */
function layClose(){
	var index = parent.layer.getFrameIndex(window.name);
	parent.layer.close(index);
}

/**
 *  layer-prompt
 *  layer 备注管理
 */
function layRemarks(url,id,msg){
	layer.prompt({title: '备注', formType: 2, value:msg}, function(text){
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type : "post",
			dataType : "JSON",
			url : url,
			data : { id : id,
				content : text
			},
			success : function(res){
				if(res.status > 0){
					layer.msg(res.message,{time:1500},function(){
						location.reload();
					});
				}else{
					layer.msg(res.message,{time:1500});
				}
			}
		});
	});
}
/**
 * layer-changeStatus
 * 使用layer改变状态值
 */
function layChangeStatus(url, word){
	layer.confirm('确定 '+ word +' 吗？',function(index){
		$.ajax({
			type : 'get',
			dataType : "JSON",
			url : url,
			success : function(res){
				if(res.status > 0){
					layer.msg(res.message,{time:1200},function(){
						location.href = res.jumpurl;
					});
				}else if(res.status == 0){
					layer.msg(res.message,{time:1200});
				}
			}
		});
	});
}

/**
 * layer-form
 * 使用layer提交表单
 */
function layAjaxForm(parameter, url, method){
	
	if(formStatus){
		layer.msg('提交中...',{time:1500});
		return true;
	}
	formStatus = true;
	
	$.ajax({
		type : method,
		dataType : "JSON",
		url : url,
		data : parameter,
		success : function(res){
			if(res.status > 0){
				if(res.status == 2){
					layer.msg(res.message,{time:1200},function(){
						location.href = res.jumpurl;
					});
				}else{
					layer.msg(res.message,{time:1200},function(){
						parent.location.reload();
						layClose();
					});
				}
			}else if(res.status == 0){
				layer.msg(res.message,{time:1500});
				formStatus = false;
			}
		}
	});
}

/**
 * layer-delete
 * 使用layer删除列表中的元素
 */
function layListDel(obj, url, id, delelement){
	$('#delid').val(id);
	layer.confirm('确认要删除吗？',function(index){	
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type : 'post',
			dataType : "JSON",
			url : url,
			data : $('#delForm').serialize(),
			success : function(res){
				if(res.status > 0){
					layer.msg(res.message,{time:1200},function(){
						if(delelement == 'reload'){
							location.reload();
							return true;
						}
						$(obj).parents(delelement).animate({opacity:'0'},1200,function(){
							$(obj).parents(delelement).remove();
						});
					});
				}else if(res.status == 0){
					layer.msg(res.message,{time:1200});
				}
			}
		});
	});
}

/**
 * layer-multi-delete
 * 使用 layer 批量删除列表中的元素
 */
function layListMultiDel(url){
	
	var id = '';
	$('[name=checkboxList]').each(function(k,obj){
		if( $(obj).prop('checked') == true){
			//去除空值（由全选/全不选框产生）
			if(this.value){
				id  += this.value + ',';
			}
		}
	});
	if(id == ''){
		layer.msg('未选中删除项',{time:1200});
		return;
	}
	id = id.substring(0,id.length-1);
	$('#delid').val(id);
	layer.confirm('确认要批量删除吗？',function(index){	
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type : 'post',
			dataType : "JSON",
			url : url,
			data : $('#delForm').serialize(),
			success : function(res){
				if(res.status > 0){
					layer.msg(res.message,{time:1200},function(){
						location.reload();
					});
				}else if(res.status == 0){
					layer.msg(res.message,{time:1200});
				}
			}
		});
	});
};

/**
 * layer-changeStatus
 * 使用layer改变状态值 并 说明理由
 */
function layRefuse(url, word){
	layer.confirm('确认'+ word +'吗？',function(index){
		layer.prompt({title: word + '理由', formType: 2}, function(text){
			$.ajax({
				type : "get",
				dataType : "JSON",
				url : url,
				data : {content : text},
				success : function(res){
					if(res.status > 0){
						layer.msg(res.message,{time:1500},function(){
							location.reload();
						});
					}else{
						layer.msg(res.message,{time:1500});
					}
				}
			});
		});
	});
}