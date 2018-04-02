<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>英语在线交互学习系统一鑫教育</title>
<!-- Bootstrap Core CSS -->
<link href="__BOW__/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- MetisMenu CSS -->
<link href="__BOW__/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
<!-- Timeline CSS -->
<link href="__DIST__/css/timeline.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="__DIST__/css/sb-admin-2.css" rel="stylesheet">
<!-- Morris Charts CSS -->
<link href="__BOW__/morrisjs/morris.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="__BOW__/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!--webuploader-->
<link href="__ROOT__/lib/webuploader/css/webuploader.css" rel="stylesheet" />
<!-- switch -->
<link rel="stylesheet" href="__CSS__/bootstrap-switch.min.css" />

<!--datatime picker-->
<link href="__BOW__/datatimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- jQuery -->
<script src="__BOW__/jquery/dist/jquery.min.js"></script>
<script src="__ROOT__/js/angular.min.js"></script>

<block name="app">
<script type="text/javascript">
    var app = angular.module('body', ['ngFileUpload']);
    app.controller('pageSize', function($scope){
        $scope.pagesize = "{:((int)I('get.pagesize') ? (int)I('get.pagesize') : 10)}";
        var url = "{:U('?pagesize=', I('get.'))}";
        $scope.pagesizeChange = function()
        {
            window.location.href = url + '?pagesize=' + $scope.pagesize;
        };
    });
</script>
</block>
<block name="headCssJs">
</block>
