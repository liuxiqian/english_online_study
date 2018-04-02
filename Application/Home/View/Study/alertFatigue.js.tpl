<script type="text/javascript">
    app.controller('alertFatigue', function ($scope, $uibModalInstance, items) {

        // 点击确定后触发
        $scope.ok = function () {
            $uibModalInstance.close();
        };
    }); 
</script>
