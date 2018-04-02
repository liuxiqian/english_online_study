<script>
    var app = angular.module('myApp', []);
    app.controller('wordCtrl', function($scope,$interval) {
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
    $interval(function () {
        if ($scope.count>0) {
            $scope.count = $scope.count-1;
        }
    }, 1000);

    // 点击正确选项出现对号错号
    $scope.choice = [
        {isAnswer:0,title:"习惯，习性",isClick:0},
        {isAnswer:1,title:"可乐",isClick:0},
        {isAnswer:0,title:"（美）甜饼干，曲奇饼",isClick:0},
        {isAnswer:0,title:"压力；紧张",isClick:0},
    ]
    $scope.click = '';
    $scope.isRight = 0;
    $scope.isChange = function(click){
        console.log(click.isAnswer);
        click.isClick = 1;
        
        if (click.isAnswer == 1) {
            $scope.isRight = 1;
        }
        

       
    }
   
    // 点击隐藏显示
    $scope.word = 1;
    $scope.button = 1;
    $scope.symbol = 1;
    $scope.counts = 1;
    $scope.picture = 1;
    $scope.wordCheck = function(){
        $scope.word = !$scope.word;
    };
    $scope.buttonCheck = function(){
        $scope.button = !$scope.button;
    };
    $scope.symbolCheck = function(){
        $scope.symbol = !$scope.symbol;
    };
    $scope.countsCheck = function(){
        $scope.counts = !$scope.counts;
    };
    $scope.pictureCheck = function(){
        $scope.picture = !$scope.picture;
    }
});
</script>
