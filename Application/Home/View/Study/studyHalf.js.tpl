<script type="text/javascript">
    app.controller('StudyHalfCtrl', function($scope,$timeout, Word, $cookieStore) {

    //获取侧边栏的信息
    $scope.studyList = Word.getStudyList();
    
    // 侧边栏隐藏
    $scope.schedule = 1;
    $scope.right = "right";
    $scope.widthLeft = "9";
    $scope.widthRight = "3";
    $scope.toggle = function(val) {
        if (val == "right") {
            $scope.right = "left";
            $scope.widthLeft = "11";
            $scope.widthRight = "1";
            $scope.schedule = !$scope.schedule;
        }
        if (val == "left") {
            $scope.right = "right";
            $scope.widthLeft = "9";
            $scope.widthRight = "3";
            $scope.schedule = !$scope.schedule;
        }
    };

    //右侧格式化时分秒计时器
    $scope.timerWithTimeout = 0;
    var startTimerWithTimeout = function() {
        $scope.timerWithTimeout = 0;
        if($scope.myTimeout){
            $timeout.cancel($scope.myTimeout);
        }
        $scope.onTimeout = function(){
            $scope.timerWithTimeout++;
            $scope.myTimeout = $timeout($scope.onTimeout,1000);
        }
        $scope.myTimeout = $timeout($scope.onTimeout,1000);
  };
  startTimerWithTimeout();
})
</script>
