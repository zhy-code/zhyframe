$(function(){
	$("body").on('mousemove','.company-menu ul li',function(){
		$(this).addClass('active').siblings().removeClass('active');
		$(this).parents('.company-menu').siblings('.company-logo-box').find('ul').eq($(this).index()).show().siblings('ul').hide();
	});
});