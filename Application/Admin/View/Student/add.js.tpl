<script>
app.controller('addStudent', function($scope, $http)
{
    $scope.regex = "^0?1[0-9]{10}$"; //手机号码的验证
    $scope.disabled = 0;
    $scope.number = "";
    $scope.password = "";
    $scope.error = "";
    $scope.validate = true;
    $scope.validate = function () {
        $scope.disabled = 1;
        // alert($scope.number);
        // alert($scope.password);
        $http.get('{:U("Student/validateAjax")}',{params:{number:$scope.number,password:$scope.password}})
       .success(function(data,status){
            $scope.disabled = 0;
            if (data.status === "SUCCESS") {
                $scope.validate = false;
            }
            else{
                $scope.error = data.data;
            }
        })
       .error(function(data,status){
            $timeout(function () {
                $scope.disabled = 0;
            },2000);
            alert("系统或网络错误");
            console.log(data);
       });
    }

})
</script>