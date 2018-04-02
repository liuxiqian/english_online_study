<script>

app.controller('userAdd', function($scope, $http)
{
    $scope.user = {:json_encode($Teacher)};
    $scope.regex = "^0?1[0-9]{10}$";    //手机号码验证
    $scope.departments = {:json_encode($allowedDepartments)};


    //监听部门变化.部门变化后，重新生成可选岗位信息
    $scope.$watch('user.department', function(newValue, oldValue){
        $scope.user.post        = $scope.user.department.allowedPosts[0];               //用户岗位
    });

    if ($scope.user.department.id == 0)
    {
        $scope.user.department = $scope.departments[0];
    }

    $scope.judge = 1;
    $scope.error = "";
    $scope.validate = function () {
        // alert($scope.user.username);
            $http.get('{:U("User/validateAjax")}',{params:{username:$scope.user.username}})
           .success(function(data,status){
                if (data.status === "SUCCESS") {
                    $scope.judge = 0;
                    $scope.error = "";
                }
                else{
                    $scope.judge = 1;
                    $scope.error = "用户名被占用";
                    console.log(data.data);
                }
            })
           .error(function(data,status){
                alert("系统或网络错误");
                console.log(data);
           });
    }
});
</script>