
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <include file="index.css" />
    <title>英语在线交互学习系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="{:add_root_path("/SBAdmin2/css/bootstrap.min.css")}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{:add_root_path("/SBAdmin2/css/metisMenu.min.css")}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{:add_root_path("/SBAdmin2/css/sb-admin-2.css")}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{:add_root_path("/SBAdmin2/css/font-awesome.min.css")}" rel="stylesheet" type="text/css">
    <link href="{:add_root_path("/SBAdmin2/css/errorClass.css")}" rel="stylesheet" type="text/css">
    <link href="{:add_root_path("/SBAdmin2/css/alertify.core.css")}" rel="stylesheet" type="text/css">
    <link href="{:add_root_path("/SBAdmin2/css/alertify.default.css")}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="content">
        <div class="container">
            <div class="row main">
                <div class="col-md-5 text-right">
                    <h3 class="title">英语在线学习后台管理系统</h3>
                </div>
                <div class="col-md-4 col-lg-4 col-md-push-1 login-form">
                    <div class="panel panel-primary">
                        <div class="panel-heading text-center">
                            请登录
                        </div>
                        <div class="panel-body">
                            <form role="form" method='post' action="{:U('Login/login')}" class="login form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">账号&nbsp;<i class="text-primary glyphicon glyphicon-user"></i>：</label>
                                    <div class="col-md-8">
                                        <input type="text" name="username" id="username" placeholder="用户名" class="form-control" autofocus/>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label  class="col-md-4 control-label">密码&nbsp;<i class="text-danger glyphicon glyphicon-lock"></i>：</label>
                                    <div class="col-md-8">
                                        <input placeholder="密码" class="form-control" name="password" id="password" type="password" />
                                    </div>
                                </div>
                                <button class="btn btn-md btn-block btn-info">
                                    登录
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid footer">
        <div class="row">
            <div class="col-md-12 text-center">
                &copy2016 -
                <script>
                document.write(new Date().getFullYear());
                </script>&nbsp;一鑫教育咨询有限公司
                <br />
                <span style="color:#888">技术支持：梦云智</span>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="{:add_root_path("/SBAdmin2/js/jquery.min.js")}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{:add_root_path("/SBAdmin2/js/bootstrap.min.js")}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{:add_root_path("/SBAdmin2/js/metisMenu.min.js")}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{:add_root_path("/SBAdmin2/js/sb-admin-2.js")}"></script>
    <script src="{:add_root_path("/SBAdmin2/js/jquery.validate.js")}"></script>
    <script src="{:add_root_path("/SBAdmin2/js/alertify.min.js")}"></script>
    {$js}

</body>
</html>
