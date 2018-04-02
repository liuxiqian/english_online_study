<script type="text/javascript">
app.controller('StudyHalfIndexCtrl', function($scope, $interval, Word, $location, $cookieStore, $document) {
    //取index页面的学生设置信息
    var indexCheckboxs = $cookieStore.get("index");
    $scope.$emit('to-parent',indexCheckboxs);
   
    //对应键盘37是←，40是↓，39是→
    $document.bind("keypress", function(event) {
        $scope.$apply(function (){
            if (event.keyCode == 37) {
                $location.path("half/identify/0");
            }
            if (event.keyCode == 40) {
                $location.path('studyWordDetail/1');
            }
            if (event.keyCode == 39) {
                $location.path("half/identify/1");
            }
        })
    });
    
    // 计时器
    $scope.count = 5;
    $interval(function() {
        if ($scope.count > 0) {
            $scope.count = $scope.count - 1;
        }
    }, 1000);
});
</script>
