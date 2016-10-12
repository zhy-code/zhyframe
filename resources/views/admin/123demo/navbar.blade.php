<!--左侧导航开始-->
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">

        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><h2 style="color: #fff;">优品后台</h2><!-- <img alt="image" src="{{ asset('img/logo.png') }}"/> --></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                       <span class="block m-t-xs"><strong class="font-bold">admin</strong></span>
                        <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <!--
                        <li><a class="J_menuItem" href="form_avatar.html">修改头像</a>
                        </li>
                        <li><a class="J_menuItem" href="profile.html">个人资料</a>
                        </li>
                        <li><a class="J_menuItem" href="contacts.html">联系我们</a>
                        </li>
                        <li><a class="J_menuItem" href="mailbox.html">信箱</a>
                        </li>
                        <li class="divider"></li>
                        -->
                        <li><a href="{{ url('/logout') }}" 
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">安全退出</a>
                        </li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
                <div class="logo-element">Cloud</div>
            </li>
            
            {{ sidebar() }}

        </ul>
    </div>
</nav>
<!--左侧导航结束-->



<!--右侧部分开始-->
<div id="page-wrapper" class="gray-bg dashbard-1">