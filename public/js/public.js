/**
 * 表单元素加密
 */
function elementEncry(obj){
	var val = $(obj).val();
	var valEncry = val ? $.md5(val) : val;
	$(obj).val(valEncry);
}

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
 * layer-changeStatus
 * 使用layer改变状态值
 */
function layChangeStatus(url, word){
	layer.confirm('确认要'+ word +'吗？',function(index){	
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
	$.ajax({
		type : method,
		dataType : "JSON",
		url : url,
		data : parameter,
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
			data : $('#userDelForm').serialize(),
			success : function(res){
				if(res.status > 0){
					layer.msg(res.message,{time:1200},function(){
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
			data : $('#userDelForm').serialize(),
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
