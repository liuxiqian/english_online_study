<script type="text/javascript">
app.controller('StudyHalfIdentifyCtrl', function($scope, $stateParams, $location, $cookieStore, $document) {
    //取identify页面的学生设置信息
    var identifyCheckboxs = $cookieStore.get("identify");
    $scope.$emit('to-parent',identifyCheckboxs);

    $document.bind("keypress", function(event) {
        $scope.$apply(function (){
            if (event.keyCode == 37) {
                $scope.jumpp($scope.word);
            }
            if (event.keyCode == 39) {
                $location.path("studyWordDetail/1");
            }
        })
    });

    var type = $stateParams.type; //判断是从（认识 or 拿不准）进入的

    // 认对
    $scope.jumpp = function (word) {
        console.log(type);
        
        // 认识，认对
        if (type == 0) {
            $scope.changeWord(word, 'know', function(){
                //新学复习自动加1
                $scope.changeCurrentCount();
                $location.path("half/index");
            });
        }

        // 拿不准，认对
        if (type == 1) {
            $location.path("studyWordDetail/2"); //从拿不准进入，跳转单词详情
        }
    }

});
</script>
