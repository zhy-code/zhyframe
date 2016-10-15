@extends('admin.common.inner_frame')

@section('head')
<!--<link rel="stylesheet" href="{{ asset('css/plugins/iCheck/custom.css') }}" />-->
@endsection

@section('content')

<body class="gray-bg">
    <div class="row">
        <div class="col-sm-12">
            <div class="wrapper wrapper-content animated fadeInUp">
                <ul class="notes">
                    @for($i=0;$i<=5;$i++)
					<li>
                        <div>
                            <small>2014年10月24日(星期五) 下午5:31</small>
                            <h4>HTML5 文档类型</h4>
                            <p>Bootstrap 使用到的某些 HTML 元素和 CSS 属性需要将页面设置为 HTML5 文档类型。在你项目中的每个页面都要参照下面的格式进行设置。</p>
                            <p>Bootstrap 使用到的某些 HTML 元素和 CSS 属性需要将页面设置为 HTML5 文档类型。在你项目中的每个页面都要参照下面的格式进行设置。</p>
                            <a href="javascript:;" onclick="layListDel(this, 'li')"><i class="fa fa-trash-o"></i></a>
                        </div>
                    </li>
					@endfor
                </ul>
            </div>
        </div>
    </div>  
@endsection

@section('footer')
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
@endsection
