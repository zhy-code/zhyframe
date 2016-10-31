$(function(){
	var box=$('.mall-img');
	var times=[1000,1500,2000,2500];
	for(var i=0;i<4;i++){
		var ban = $('.mall-img').eq(i),
        img = ban.find('img');
        lunbo(img,times[i]);
	}
	function lunbo(obj,time){
		
        var n = 0;
	    var t =setInterval(move,time);
	    function move(){
	        obj.eq(n).animate({opacity:0},1000);
	        obj.eq(n+1).animate({opacity:1},1000);
	        n+=1;
	        if(n===obj.length){
	            n=0
	            obj.eq(n).animate({opacity:1},1000);
	        };
	    };
	};
	
	
});