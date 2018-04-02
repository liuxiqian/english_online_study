<script>
var app = angular.module('myApp', []);
app.controller('wordCtrl', function($scope, $interval, $document) {
    $document.bind("keypress", function(event) {
        if (event.keyCode == 37) {
            alert('认识');
        }
        if (event.keyCode == 39) {
            alert('拿不准');
        }
        if (event.keyCode == 40) {
            alert('不认识');
        }
    });

    $scope.word = {:json_encode($Word -> getJsonData())};

    $scope.speak = function($type) {
        var src = $scope.word.audioUkUrl;
        if ($type == 'us')
        {
            var src = $scope.word.audioUsUrl;
        }
        
        if (window.HTMLAudioElement) {
            try {
                var Audio = document.getElementById('audio');
                Audio.src = src;
                Audio.play();
            } catch (e) {
                if (window.console && console.error("Error:" + e));
            }
        }
    }
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

    // 计时器
    $scope.count = 5;
    $interval(function() {
        if ($scope.count > 0) {
            $scope.count = $scope.count - 1;
        }
    }, 1000);

    // 点击正确选项出现对号错号
    $scope.choice = [{
        value: "0",
        title: "习惯，习性",
        check: "fa fa-check true",
        times: "fa fa-times false"
    }, {
        value: "1",
        title: "可乐",
        check: "fa fa-check true",
        times: "fa fa-times false"
    }, {
        value: "0",
        title: "（美）甜饼干，曲奇饼",
        check: "fa fa-check true",
        times: "fa fa-times false"
    }, {
        value: "0",
        title: "压力；紧张",
        check: "fa fa-check true",
        times: "fa fa-times false"
    }, ]
    $scope.myVar = 0;
    $scope.select = "";
    $scope.click = function(val) {

            if (val.value == 1) {
                $scope.select = val.check;
                $scope.myVar = 1;
            }
            if (val.value == 0) {
                $scope.select = val.times;
            }
        }
        // 点击隐藏显示
    $scope.showWord = 1;
    $scope.UK = 1;
    $scope.US = 1;
    $scope.symbol = 1;
    $scope.syllable = 1;
    $scope.counts = 1;
    $scope.picture = 1;

    $scope.wordCheck = function() {
        $scope.showWord = !$scope.showWord;
    };
    $scope.USCheck = function() {
        $scope.US = !$scope.US;
    };
    $scope.UKCheck = function() {
        $scope.UK = !$scope.UK;
    };
    $scope.symbolCheck = function() {
        $scope.symbol = !$scope.symbol;
    };
    $scope.syllableCheck = function() {
        $scope.syllable = !$scope.syllable;
    };
    $scope.countsCheck = function() {
        $scope.counts = !$scope.counts;
    };
    $scope.pictureCheck = function() {
        $scope.picture = !$scope.picture;
    }
});
</script>
