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