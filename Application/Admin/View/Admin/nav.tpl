<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="http://www.yunzhiclub.com">英语在线学习后台管理系统</a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">{:$ConstructM->getUserName()}
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <!-- <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li> -->
                <li><a href="{:U('Login/loginOut')}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <foreach name="ConstructM:getMenuLists()" item="list">
                <eq name="list['module']" value="Admin">
                <php>
                    if (isset($list['_son']))
                    {
                </php>
                    <li class="<eq name="ConstructM:checkIsCurrent($list)" value="1">active</eq>">
                        <a href="javascript:void(0);"><i class="{$list['icon']}"></i> {$list['title']}<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level <eq name="ConstructM:checkIsCurrent($list)" value="1">collapse in<else />collapse</eq>">
                            <foreach name="list['_son']" item="son">
                            <li>
                                 <a class="<eq name="ConstructM:checkIsCurrent($son)" value="1">active</eq><eq name="son['is_done']" value="0"> text-danger</eq>" href="{:U($son['controller'] . '/' . $son['action'])}"><i class="{$son['icon']}"></i> {$son['title']}<?php  if(APP_DEBUG) echo "  " . $son['dev_user']; ?></a>
                            </li>
                            </foreach>
                        </ul>
                    </li>
                <php>
                    }
                    else
                    {
                </php>
                    <li>
                        <a class="<eq name="ConstructM:checkIsCurrent($list)" value="1">active</eq><eq name="list['is_done']" value="0"> text-danger</eq>" href="{:U($list['controller'] . '/' . $list['action'])}"><i class="{$list['icon']}"></i> {$list['title']}<?php  if(APP_DEBUG) echo "  " . $list['dev_user']; ?></a>
                    </li>

                <php>
                    }
                </php>
                    
                   
                </eq>
                </foreach>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
