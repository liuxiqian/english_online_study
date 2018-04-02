<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand  navbar-brand-centered" href="#">一鑫教育</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <foreach name="Menus" item="Menu">
                    <li class="<eq name="Menu:getIsActive()" value="true">active</eq>">
                    <a class="<eq name="Menu:getIsCurrent()" value="true">active</eq>" href="{:U($Menu->getController() . '/' . $Menu->getAction())}"><i class="{$Menu->getIcon()}"></i>{$Menu->getTitle()}<neq name="Menu:getUnReadMessageCount($Student)" vaule="0"> <span class="badge">{$Menu->getUnReadMessageCount($Student)}</span></neq></a>
                    </li>
                </foreach>
                <li><a href="{:U('Login/logout')}">注销 <span class="glyphicon glyphicon-log-out"></span></a></li>
            </ul>
        </div>
    </div>
</nav>
<style>
    .navbar {
        margin-bottom: 0;
        background-color: #1abc9c;
        z-index: 9999;
        border: 0;
        font-size: 12px !important;
        line-height: 1.42857143 !important;
        letter-spacing: 4px;
        border-radius: 0;
    }

    .navbar li a, .navbar .navbar-brand {
        color: #fff !important;
    }

    .navbar-nav li a:hover, .navbar-nav li.active a {
        color: #1abc9c !important;
        background-color: #fff !important;
    }

    .navbar-default .navbar-toggle {
        border-color: transparent;
        color: #fff !important;
    }

    .navbar-brand-centered {
        position: absolute;
        left: 10%;
        display: block;
        text-align: center;
        background-color: transparent;
    }
    .navbar>.container .navbar-brand-centered,
    .navbar>.container-fluid .navbar-brand-centered {
        margin-left: -80px;
    }
</style>