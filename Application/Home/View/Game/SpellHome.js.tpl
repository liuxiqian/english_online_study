<script>
var App = angular.module('App',['ui.bootstrap', 'ngAnimate']);

App.controller('Spell', ['$scope','$http', '$timeout', '$interval', '$window', function($scope, $http, $timeout, $interval, $window){
    var cryPng =  "__IMG__/cry.png";        // 哭脸
    var smilePng =  "__IMG__/smile.png";    // 笑脸
    var courseId = {:I("get.courseId")};                      // 课程ID
    var url = '{:U("Game/getNextSpellWordAjax")}' + '?courseId=' + courseId;                   // 抓取单词的URL
        
    $scope.rightCount = 0;                  // 答对题的个数
    $scope.wrongCount = 0;                  // 答错题的个数
    $scope.isShowAudio  = true;             // 是否发音
    $scope.isShowExplain = true;            // 是否显示释义
    $scope.word = {:json_encode($Word->getJsonData())};                   // 单词
    $scope.spell = '';                      // 用户输入的拼写
    $scope.totalTime = 60;                  // 游戏时长
    $scope.remainTime = $scope.totalTime;   // 剩余游戏时长
    $scope.placeholder = '';                // 输出提示
    $scope.picUrl = '';                     // 提示答对或答错的图片URL
    $scope.showPic = false;                 // 是否显示答对或是答错的图片


    // 用户点击确认或是按下回车后，进行单词拼写是否正确的检查
    $scope.pressEnter = function () {
        // 判断用户输入是否正确
        if ($scope.spell.trim() === $scope.word.title.trim()) {
            $scope.rightCount++;
            showImage('right');             // 显示答对的图标
            $scope.placeholder = '';        // 清空提示
            getNextWord(function(){         // 获取下一个单词
                // 清除输入
                $scope.spell = ''; 

                // 自动读音
                if ($scope.isShowAudio) {
                    speak($scope.word.audioUkUrl);
                }  
            });                  
        } else {
            $scope.wrongCount++;
            showImage('wrong');
            // 清除输入
            $scope.spell = ''; 
            // 提示正确答案
            $scope.placeholder = $scope.word.title.trim();
        }
        

    };

    // 发音
    $scope.speak = function () {
        speak($scope.word.audioUkUrl);
    };



    // 显示答对或是答错的图片
    var showImage = function(isRight = 'right') {
        var url = cryPng;
        if (isRight === 'right') {
            url = smilePng;
        }
        $scope.showPic = true;
        $scope.picUrl = url;

        $timeout(function (){
            $scope.showPic = false;
        }, 1000);
    };

    // 获取下一个单词
    var getNextWord = function (callback) {
        $http({
            method:'GET',
            url: url,
        }).then(function successCallback(response){
            // 较验状态码
            if (response.status !== 200) {
                alert('数据请求错误，错误码' + response.status);
                return;
            } 

            // 较验返回数据
            if (response.data.status === 'error') {
                alert('程序错误：' + response.data.message);
                return;
            }

            // 赋值
            $scope.word = response.data.data;

            // 执行回调
            if (typeof(callback) === 'function') {
                callback();
            }
        }, function errorCallback(response){
            alert('数据请求失败，请联系管理员');
        });
    }

    // 点击发音
    var speak = function(src, audioId='audio') {
        if (window.HTMLAudioElement) {
            try {
                var Audio = document.getElementById('audio');
                Audio.src = src;
                Audio.play();
            } catch (e) {
                if (window.console && console.error("Error:" + e));
            }
        }
    };  

    speak($scope.word.audioUkUrl);

    //倒计时
    $interval(function() {
        if ($scope.remainTime > 0) {
            $scope.remainTime--;

        }

        if ($scope.remainTime == 0) {
            alert('本次游戏结束');
            $interval.cancel(stop);
            $window.location.reload();

        }

    }, 1000);

    
}]);

// 注册 pressEnter 监听用户按下回车事件
App.directive('pressEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.pressEnter);
                });

                event.preventDefault();
            }
        });
    };
});

</script>