<script>
var app = angular.module('student', ['ngFileUpload']);
app.controller('add', function($scope, $http, Upload, $timeout) {
    $scope.hasError = "";           // 错误信息
    $scope.repassword = "";         // 重复密码
    $scope.submitDisable = 0;       // 提前按钮是否可用

    // 学生初始化
    $scope.student = {
        indexOfFatigueId: '{:$Student->getIndexOfFatigueId()}',
        compare:{:$Student->getPlayWithWhoes()},
        isHero: {:$Student->getWishExample()},
        imgUrl: '{:$Student->getAttachment()->getUrl()}',
        name: '{:$Student->getName()}',
        sex: '{:$Student->getSex()}',
        school: '{:$Student->getSchool()}',
        attachmentId: {:$Student->getAttachmentId()},
        password: '',
        newPassword: '',
    };

    // 监视密码输入
    $scope.$watchGroup(["student.newPassword", "repassword", 'student.password'], function() {
        if ($scope.student.password != '' && ($scope.student.newPassword == undefined || $scope.student.newPassword == ''))
        {
            $scope.submitDisable = 1;
        }
        else if ($scope.student.newPassword !== $scope.repassword) {
            $scope.hasError = "两次密码不一致";
            $scope.submitDisable = 1;
        } else {
            $scope.hasError = "";
            $scope.submitDisable = 0;
        }
    });

    // 表单提交 
    $scope.submit = function(){
        $http({
            method  : 'POST',
            url     : '{:U("saveAjax")}',
            data    :  $scope.student,  
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
        })
        .success(function(data) {
            console.log(data);
            if ( data.status == 'SUCCESS' ) {
                alert('操作成功');
                $scope.error = '操作成功!';
               $scope.repassword = '';
               $scope.student.password = '';
               $scope.student.newPassword = '';
            } else {
                $scope.error = '错误信息:' + data.message;
            }

            // 在1.5秒后清空提示信息
            $timeout(function() {
                $scope.error = '';
                return;
            }, 1500);
        });
    };

     // upload on file select or drop
    $scope.upload = function (file) {
        if (file)
        {
            Upload.upload({
                url: '{:U("uploadAjax")}',
                data: {yunzhifile: file}
            }).then(function (resp) {
                if (resp.data.state === "ERROR")
                {
                    alert("系统错误:"+resp.data.message);
                }
                else
                {
                    $scope.student.attachmentId = resp.data.id;
                    $scope.student.imgUrl = resp.data.url;
                }
                console.log(resp);
            }, function (resp) {
                alert("系统未成功返回信息");
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            });
        }
        
    };
});
</script>
