<script>
app.controller("edit", function($scope) {
    $scope.email = "{$user.email}"; //邮箱的验证
    $scope.phonenumber = "{$user.phonenumber}";
    $scope.regex = "^0?1[0-9]{10}$"; //手机号码的验证
    //确认密码验证
    $scope.hasError = "";
    $scope.newpassword = "";
    $scope.repassword = "";
    $scope.submitDisable = 0;

    $scope.submit = function() {};
    $scope.$watchGroup(["newpassword", "repassword"], function() {
        if ($scope.newpassword !== $scope.repassword) {
            $scope.hasError = "两次密码不一致";
            $scope.submitDisable = 1;
        } else {
            $scope.hasError = "";
            $scope.submitDisable = 0;
        }
    });
})
</script>
