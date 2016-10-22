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

/**
 * layer-form
 * 使用layer删除列表中的元素
 */
function layAjaxForm(parameter, url, method){
	$.ajax({
		type : method,
		dataType : "JSON",
		url : url,
		data : parameter,
		success : function(res){
			if(res.status > 0){
				layer.msg(res.info,{time:1200},function(){
					location.href = res.jumpurl;
				});
			}else{
				layer.msg(res.info,{time:1200});
			}
		}
	});
}