<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <title>一鑫教育爆破式英语学习平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="__ROOT__/Admin/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
    <include file="index.css"/>
</head>

<body>
<div class="content">
    <div class="container-fuild">
        <div class="row main">
            <section class="login-block">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 login-sec">
                            <h2 class="text-center">Login Now</h2>
                            <form class="login-form" method='post' action="{:U('Login/login')}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="text-uppercase">Username</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                           placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="">
                                </div>
                                <div class="form-check">
                                    <button type="submit" class="btn btn-login float-right">Submit</button>
                                </div>

                            </form>
                        </div>
                        <div class="col-md-8 banner-sec">
                            <div class="banner-text">
                                <h2>Welcome!</h2>
                                <p>Thank you for adding and wishing you healthy forever! Happy day! </p>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <div class="container-fluid footer">
                <div class="row">
                    <div class="col-md-12 text-center">
                        &copy2016 -
                        <script>
                            document.write(new Date().getFullYear());
                        </script>&nbsp;一鑫教育咨询有限公司
                        <br/>
                        <small></small><span style="color:#888">技术支持：梦云智</span>
                    </div>
                </div>
            </div>
</body>

</html>
