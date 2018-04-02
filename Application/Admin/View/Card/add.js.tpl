<script>
app.controller('cardCtrl', function($scope, $timeout, $http) {
    $scope.disabled = 0;//获取验证码按钮显示
    $scope.code = null;//输入验证码的input框的value
    $scope.update = 1;
    $scope.err = null;
    $scope.mum = null;

    //ajax获取手机验证码
    $scope.setAuthCode = function() {
        $scope.disabled = 1;
        $http.get('getAuthCode')
        .success(function(data, status) {
            if (data.status === "SUCCESS") {
                $scope.mum = 60;
                timer();
            }
            else{
              alert(data.result);
            }
        })
        .error(function(data, status) {
            alert("未找到此方法!");
        });
    }

    //内容change的时候触发此方法
    //验证输入的手机号是否正确
    $scope.verify = function (code) {
        if (code.length == 6) {
            $http.get('verify',{params:{code:code}})
            .success(function(data,status){
                if (data.status === "SUCCESS") {
                    $scope.update = 0;
                }
                else{
                    $scope.update = 1;
                    $scope.err = data.message;
                }
            })
            .error(function(data,status){
              alert("系统或网络错误");
            });
        }
        else{
            $scope.update = 1;
        }
    }

    //倒计时方法
    var timer = function() {
        $timeout(function() {
            $scope.mum--;
            if ($scope.mum == 0) {
                $scope.mum = null;
                $scope.disabled = 0;
                return;
            } else {
                timer();
            }
        }, 1000);
    }

    // 绑定验证
    $scope.num           = 10; //绑定生成个数默认值为100个
    $scope.effective_days = 100; //绑定有效日期默认值为100天

    //datepicker
    $('.datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:true,
        autoclose: true,
        todayBtn: true,

        minView: 2

    });
})
</script>
