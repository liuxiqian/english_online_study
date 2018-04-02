<script type="text/javascript">
var app = angular.module('myApp', ['ngAnimate']);
app.controller("MyArticle", function($scope) {
    $scope.myCheck = 1;
    $scope.audio = {};
    
    $scope.allArticle = function() {

        $scope.myCheck = !$scope.myCheck;
    }
    // todo 播放音频文件，引入播放器
    $scope.audio.src = "{$Article->getAttachment()->getAudioUrl()}";

    // 播放音频文件
    $scope.togglePlay =  function(){
        $scope.showPlayer = true;
        togglePlay('audio', $scope.audio.src);
    };
});
</script>
