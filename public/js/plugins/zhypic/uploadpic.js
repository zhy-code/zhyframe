/**
 * Author:ZhengYan
 * Last EditDate: 2016-05-31
 *
 */

/**
 * 主函数 只调用它
 * @parameter: setwidth:图片的宽度;  quality: 图片压缩质量; boxid: 图片展示区的id值; fieldname保存的字段名称
 */
function picload(event,setwidth,quality,boxid,fieldname) {			
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
		
		picpress(blob,setwidth,quality,boxid,fieldname);
	};						        
}

/**
 * 图片压缩主函数
 */
function picpress(blob,width,quality,boxid,fieldname){
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
		var base64 = canvas.toDataURL('image/png', quality || 0.9);
		
		// 生成结果
		result = {
			base64: base64,
			clearBase64: base64.substr(base64.indexOf(',') + 1)
		};
		
		if(fieldname.indexOf('more_')>=0){
			dealmorepic(result,boxid,fieldname);
		}else{
			dealpic(result,boxid,fieldname);
		}
	};
}

/**
 * 处理生成结果，追加到相应的div区域内
 */
function dealpic(result,boxid,fieldname){
	var new_img ='<div class="MobImgUpl_imgBox"><div class="MobImgUpl_img"><img src="'+result.base64+'" style="width:200px"></div>';
		new_img+='<input type="hidden" name="'+fieldname+'" value="'+result.base64+'"></div>';
	
	$('#'+boxid).html(new_img);
}


/**
 * 处理生成结果，追加到相应的div区域内 ---- 多图
 */
function dealmorepic(result,boxid,fieldname){
	var new_img ='<li><div class="MobImgUpl_imgBox"><div class="MobImgUpl_img"><img src="'+result.base64+'"></div></div>';
		new_img+='<i class="fa fa-trash" onclick="$(this).parent().remove();"></i>';
		new_img+='<input type="hidden" name="'+fieldname+'" value="'+result.base64+'">';
		new_img+='</li>';
	
	$('#'+boxid).before(new_img);
}