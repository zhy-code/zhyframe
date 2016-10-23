/**
 * 表单元素加密
 */
function elementEncry(obj){
	var val = $(obj).val();
	var valEncry = val ? $.md5(val) : val;
	$(obj).val(valEncry);
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
function layListDel(obj, delelement){
	layer.confirm('确认要删除吗？',function(index){	
		layer.msg('删除成功',{time:1200},function(){
			$(obj).parents(delelement).animate({opacity:'0'},1200,function(){
				$(obj).parents(delelement).remove();
			});
		});
	});
}
