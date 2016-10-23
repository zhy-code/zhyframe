<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="nav-close"><i class="fa fa-times-circle"></i>
            </div>
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header" style="text-align:center">
                        <div class="dropdown profile-element">
                            <span><img alt="image" class="img-circle" style="width:75px;height:75px;" src="img/admin_headpic.jpg" /></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block mt-15" style="font-size:20px;">{{$adminuser['user_name']}}</span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="J_menuItem" href="profile.html">个人信息</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="/admin/logout">安全退出</a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">Snow</div>
                    </li>
					@if ($menulist)
					@foreach ($menulist as $key => $val)
                    <li>
                        @if ($val['soninfo'])
						<a href="#">
                            <i class="fa fa-{{$val['menu_icon']}}"></i>
                            <span class="nav-label" style="font-size:15px;">{{$val['menu_name']}}</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
							@foreach ($val['soninfo'] as $k => $v)
                            <li>
                                <a class="J_menuItem" href="/{{strtolower($v['menu_module'])}}/{{strtolower($v['menu_controller'])}}/{{strtolower($v['menu_action'])}}/{{strtolower($v['menu_parameter'])}}">{{$v['menu_name']}}</a>
                            </li>
							@endforeach
                        </ul>
						@else
							<a class="J_menuItem" href="/{{strtolower($val['menu_module'])}}/{{strtolower($val['menu_controller'])}}/{{strtolower($val['menu_action'])}}/{{strtolower($val['menu_parameter'])}}"><i class="fa fa-{{$val['menu_icon']}}"></i> <span class="nav-label">{{$val['menu_name']}}</span></a>
						@endif
                    </li>
					@endforeach
					@endif
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->
		<!--右侧部分开始-->
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 5px">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
					</div>
				</nav>
			</div>
			
			<div class="row content-tabs">
				<button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
				</button>
				<nav class="page-tabs J_menuTabs">
					<div class="page-tabs-content">
						<a href="javascript:;" class="active J_menuTab" data-id="{{url('/admin/welcome')}}">首页</a>
					</div>
				</nav>
				<button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
				</button>
				<div class="btn-group roll-nav roll-right">
					<button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

					</button>
					<ul role="menu" class="dropdown-menu dropdown-menu-right">
						<li class="J_tabShowActive"><a>定位当前选项卡</a>
						</li>
						<li class="divider"></li>
						<li class="J_tabCloseAll"><a>关闭全部选项卡</a>
						</li>
						<li class="J_tabCloseOther"><a>关闭其他选项卡</a>
						</li>
					</ul>
				</div>
				<a href="/admin/logout" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
			</div>
			<div class="row J_mainContent" id="content-main">
				<iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{url('/admin/welcome')}}" frameborder="0" data-id="{{url('/admin/welcome')}}" seamless></iframe>
			</div>
			<div class="footer">
				<div class="pull-right">&copy; 2016-2018 <a href="http://www.5cub.com" target="_blank">zhyframe</a>
				</div>
			</div>
		</div>
		<!--右侧部分结束-->
	</div>