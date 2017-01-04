/**
 * Author:Zheng
 * Last EditDate: 2017-01-03
 *
 */

/**
 * 主函数 只调用它
 * @parameter: setwidth:图片的宽度;  quality: 图片压缩质量; boxid: img的id和保存input的name; 
 */
function imgload(event,setwidth,quality,boxid) {			
	var n = event.target.files.length;	        
	var file;
	for (var i = 0; i < n; i++) {
		file=event.target.files[i];
		
		if (window.createObjectURL!=undefined) {
			var blob = window.createObjectURL(file) ; 
		} else if (window.URL!=undefined) {
			var blob = window.URL.createObjectURL(file) ;
		} else if (window.webkitURL!=undefined) {
			var blob = window.webkitURL.createObjectURL(file);
		} 
		
		imgpress(blob,setwidth,quality,boxid);
	};						        
}

/**
 * 图片压缩主函数
 */
function imgpress(blob,width,quality,boxid){
	var img = new Image();
	img.src = blob;

	img.onload = function(){
		var that = this;
		//生成比例
		var w = that.width,
			h = that.height,
			scale = w / h;
		w = width || w;
		h = w / scale;

		//生成canvas
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
		$(canvas).attr({
			width: w,
			height: h
		});
		ctx.drawImage(that, 0, 0, w, h);

		/**
		 * 生成base64
		 * 兼容修复移动设备需要引入mobileBUGFix.js
		 */
		var base64 = canvas.toDataURL('image/jpeg', quality || 0.9);
		/*
		// 修复IOS
		if (navigator.userAgent.match(/iphone/i)) {
			var mpImg = new MegaPixImage(img);
			mpImg.render(canvas, {
				maxWidth: w,
				maxHeight: h,
				quality: quality || 0.9
			});
			base64 = canvas.toDataURL('image/jpeg', quality || 0.9);
		}

		// 修复android
		if (navigator.userAgent.match(/Android/i)) {
			var encoder = new JPEGEncoder();
			base64 = encoder.encode(ctx.getImageData(0, 0, w, h), quality * 100 || 90);
		}
		*/
		// 生成结果
		result = {
			base64: base64,
			clearBase64: base64.substr(base64.indexOf(',') + 1)
		};
		
		dealimg(result,boxid);
	};
}

/**
 * 处理生成结果，追加到相应的input和img区域内
 */
function dealimg(result,boxid){
	
	$('#'+boxid).attr('src',result.base64);
	$('input[name="'+boxid+'"]').val(result.base64);

	
	//$('#'+boxid).find('span').hide();
}