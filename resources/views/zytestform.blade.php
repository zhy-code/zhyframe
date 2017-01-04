@extends('admin.common.zhyframe')

@section('head')
<link rel="stylesheet" href="{{asset('test/css/store.css')}}" />
@endsection

@section('content')

<div>
<!-- 中间 -->
<div class="col-sm-12" style="margin-top:60px;">
    <div class="ibox">
        <div class="ibox-content">
			<div class="col-sm-12">
				<div class="ibox-title">
					<h5>商品属性规格</h5>
				</div>
				<div class="ibox-content">
					<form class="form-horizontal" role="form" id="tsetInfoForm">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="col-sm-2 control-label">商品属性：</label><span class="btn btn-sm btn-primary btn-add-attr"><span>新增属性</span></span>
						<div class="col-sm-12 no-padding cg-attr-lists">
							<div class="attr-lists">
								<div class="col-md-12 attr-node">
									<span class="btn btn-white btn-sm">
										<input data-id="0" type="text" name="attr_title[]" placeholder="属性类型" class="form-control attr_title" style="border:0px">
									</span>
									<a href="javascript:void(0)" onclick="toadd(this,0)">添加</a>
									<a href="javascript:void(0)" onclick="toup(this)">向上</a>
									<a href="javascript:void(0)" onclick="todown(this)">向下</a>
									<a href="javascript:void(0)" onclick="todel(this)">移除</a>
								</div>
							</div>
						</div>
					</div>

					<div class="cg-select-spec">
						<div class="form-group">
							<label class="col-sm-2 control-label">商品规格：</label>
							<div class="col-sm-10 cg-spec-lists">
								
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">&nbsp;</label>
							<div class="col-sm-10 cg-spec-value-input">
								
							</div>
						</div>
					</div>
					<div class="form-group mt-50">
						<div class="col-sm-4 col-sm-offset-5 ">
							<span class="btn btn-primary" onclick="layAjaxForm($('#tsetInfoForm').serialize(), '/ddtest', 'post')">保&nbsp;&nbsp;存</span>
							<span class="btn btn-white ml-15" onclick="layClose()">取&nbsp;&nbsp;消</span>
						</div>
					</div>
					</form>
				</div>
				<input type="hidden" id="allAttrName">
				<input type="hidden" id="allAttrVal">
			</div>
        </div>
    </div>
</div>

</div>
</div>
@endsection

@section('footer')
<script>
/**
 * 添加属性
 */
 $('.btn-add-attr').click(function(e) {
	var title_n = $('.attr_title').length;
	var str = '';
	str = '<div class="col-md-12 attr-node">'+
			'<span class="btn btn-white btn-sm">'+
			'<input type="text" placeholder="属性类型" name="attr_title[]" class="form-control attr_title" style="border:0px" data-id="'+ title_n +'"></span>'+
			'<a href="javascript:void(0)" onclick="toadd(this,'+ title_n +')">添加</a>'+
			'<a href="javascript:void(0)" onclick="toup(this)">向上</a>'+
			'<a href="javascript:void(0)" onclick="todown(this)">向下</a>'+
			'<a href="javascript:void(0)" onclick="todel(this)">移除</a>'+
		'</div>';
	$('.attr-lists').append(str);
 });

function toup(obj){
	var parent = $(obj).parent();
	$(parent).prev().before(parent);
	setTableData();
}

function todown(obj){
	var parent = $(obj).parent();
	$(parent).next().after(parent);
	setTableData();
}

function toadd(obj,id){
	var str = '<span class="btn btn-white btn-rounded btn-sm"><input type="text" placeholder="属性值" class="form-control attr_value" data-pid="'+id+'" style="border:0px;"><span style="font-size:24px;margin-left:5px;" onclick="todel(this)">×</span></span>';
	$(obj).before(str);
}

function todel(obj){
	$(obj).parent().remove();
	setTableData();
}

$('.cg-attr-lists').on('change', '.attr_title', function() {
	setTableData();
});

$('.cg-attr-lists').on('change', '.attr_value', function() {
	setTableData();
});

function setTableData(){
	var allAttrName  = new Array();
	$('.attr_title').each(function(){
		if($(this).val()){
			if(allAttrName[$(this).attr('data-id')] instanceof Array){
				allAttrName[$(this).attr('data-id')][allAttrName[$(this).attr('data-id')].length]=$(this).val();
			}else{
				allAttrName[$(this).attr('data-id')] = new Array();
				allAttrName[$(this).attr('data-id')][0]=$(this).val();
			}
		}
	});
	$('#allAttrName').val(JSON.stringify(allAttrName));
	
	var allAttrVal  = new Array();
	$('.attr_value').each(function(index){
		if($(this).val()){
			if(allAttrVal[$(this).attr('data-pid')] instanceof Array){
				allAttrVal[$(this).attr('data-pid')][allAttrVal[$(this).attr('data-pid')].length]=$(this).val();
			}else{
				allAttrVal[$(this).attr('data-pid')] = new Array();
				allAttrVal[$(this).attr('data-pid')][0]=$(this).val();
			}
		}
	});
	$('#allAttrVal').val(JSON.stringify(allAttrVal));
	
	eachSpecInput();
}

var Spec = function(specName,specItems){
    this.specName = specName; //属性名称
    this.specItems = specItems;//数值值，是个数组，数组个数不确定
}

/**
 * 输入规格录入框
 */

function eachSpecInput() {
	var allAttrName = JSON.parse($('#allAttrName').val());
	var allAttrVal = JSON.parse($('#allAttrVal').val());
	var selectSpec = new Array();
	for(var k in allAttrName){
		selectSpec[k] = new Spec(allAttrName[k],allAttrVal[k]);
	}
	var resData = [];
	combine(0, {}, selectSpec,resData);
	//getSpecStorage();
	var specHtml = '';
	specHtml += '<table class="table table-bordered">'
        + '<thead>'
            + '<tr>';
            $.each(allAttrName, function(key, value) {
            	specHtml += '<th class="spec-title">'+value+'</th>';
            });
                specHtml += '<th>价格（元）</th>'
                + '<th>原价格（元）</th>'
                + '<th>库存</th>'
            + '</tr>'
        + '</thead>'
        + '<tbody>';
				if(false !== resData){
					$.each(resData, function(key, value) {
						//console.log(value);
						var keystr = '';
						for(var vk in value){
							keystr += value[vk] + '_';
						}
						specHtml += '<tr data-kid="'+ keystr +'">';
							$.each(value, function(k, v) {
								specHtml += '<td>'+v+'<input type="hidden" value="'+v+'" name="item['+key+'][attrname]['+k+']"></td>';
							});
							specHtml += '<td><input type="text" name="item['+key+'][price]" data-param="price" class="table-value" placeholder="请输入价格"></td>'
							+ '<td><input type="text" name="item['+key+'][oldprice]" data-param="oldprice" class="table-value" placeholder="请输入原价格"></td>'
							+ '<td><input type="text" name="item['+key+'][store]" data-param="store" class="table-value" placeholder="请输入库存"></td>'
						+ '</tr>';
					});
				}
				
        specHtml += '</tbody>'
    + '</table>';
    $('.cg-spec-value-input').html( specHtml );

    setSpecStorage();
}
 
/**
 * 发布一款商品选择的一个属性，这是一个规格数组，数组个数不确定
 * 根据这个选择的属性组合成不同的产品
 */

function combine(index, current, selectSpec, result){

	if (index < selectSpec.length - 1){
		var specItem = selectSpec[index];
		var keya = specItem.specName;
		var items = specItem.specItems;
		if(items == undefined){
			return false;
		}
		if(items.length==0){
			combine( index + 1, current, selectSpec, result);
		}
		for (var i = 0; i < items.length; i++){
			if(!items[i])continue;
			var newMap = {};
			newMap = $.extend(newMap,current);
			newMap[keya] = items[i];
			combine( index + 1, newMap, selectSpec, result);
		}
	}else if (index == selectSpec.length - 1){
		var specItem = selectSpec[index];
		var keya = specItem.specName;
		var items = specItem.specItems;
		if(items == undefined){
			return false;
		}
		if(items.length==0){
			result.push(current);
		}
		for (var i = 0; i < items.length; i++){
			if(!items[i])continue;
			var newMap = {};
			newMap = $.extend(newMap,current);
			newMap[keya] = items[i];
			result.push(newMap);
		}
	}
}

/**
 * input 输入后触发表格数据记录
 */
$('.cg-spec-value-input').on('blur', '.table-value', function() {
	getSpecStorage();
});

var specStorage = {};

/**
 * 记录库存信息
 */
function getSpecStorage() {
	var trNodeValue = $('.cg-spec-value-input tbody tr');
	if ( trNodeValue.length > 0 ) {
		specStorage = {};
		trNodeValue.each(function(event) {
			var key_id = $(this).attr('data-kid');
			specStorage[key_id] = {
				'price': $(this).find('input[data-param="price"]').val(),
				'oldprice': $(this).find('input[data-param="oldprice"]').val(),
				'store': $(this).find('input[data-param="store"]').val(),
			};
		});
	}
	//console.log(specStorage);
}
/**
 * 把记录的库存信息追加到input中
 */
function setSpecStorage() {
	var trNodeValue = $('.cg-spec-value-input tbody');
	if ( trNodeValue.length > 0 ) {
		$.each(specStorage, function(k, v) {
			trNodeValue.find('tr[data-kid^="'+k+'"]').find('input[data-param="price"]').val( v.price );
			trNodeValue.find('tr[data-kid^="'+k+'"]').find('input[data-param="oldprice"]').val( v.oldprice );
			trNodeValue.find('tr[data-kid^="'+k+'"]').find('input[data-param="store"]').val( v.store );
		});
	}
}
</script>
<script src="{{asset('js/public.js')}}"></script>
@endsection
</body>
</html>