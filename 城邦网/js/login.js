$(function(){
	$("body").on('click','.reder span',function(){
		$(this).toggleClass('active');
		$(this).find('i').toggle();
		$(this).parent('.reder').siblings('button').toggleClass('active');
	});

	//切换
	$("body").on('click','.form-top a',function(){
		$(this).addClass('active').siblings().removeClass('active');
		$(this).parent().siblings('.form-center').find('form').hide().eq($(this).index()).show();
	});

	//倒计时
	$(".btn").click(function(){
        $(this).hide();
        $('.send_code').show();
        $(".send_code .repeat").css("display","block");

        /*倒计时*/
        obt=function(){
            var time=60;
            var time_f;
            time_f=setInterval(function(){
                if(time==1){
                    clearInterval(time_f);
                    $(" .send_code .repeat").hide();
                    $(".send_code .obtain").show().html("重新获取");
                    $(" .send_code .repeat .count_down").html('(60s)');
                }else{
                    time--;
                    $(" .send_code .repeat .count_down").html('('+time+'s)');
                }
            },1000);
            }
            obt();
    });
      $(".send_code .obtain").click(function(){
        $(this).hide();
        $(".send_code .repeat").css("display","block");
        obt();
    });
})