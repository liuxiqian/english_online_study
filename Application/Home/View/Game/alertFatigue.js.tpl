<script type="text/javascript">
    myapp.controller('alertFatigue', function ($scope, $uibModalInstance, items) {

        // 点击确定后触发
        $scope.ok = function () {
            // window.location.reload();
            window.history.back(-1);
        };
        $scope.cancel = function () {
            var id = "{:I('get.courseId')}";
            var url = "{:U('Wordhome/index/id/"+ id +"')}";
            window.location.href = url;
            // window.history.back(-1);
        };
    }); 
</script>
