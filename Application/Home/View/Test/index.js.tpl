<script type="text/javascript">
var app = angular.module('yunzhi', ['ui.bootstrap', 'ionic', 'ngAnimate']);
app.filter('secondsToDateTime', [function() {
    return function(seconds) {
        return new Date(1970, 0, 1).setSeconds(seconds);
    };
}]);    // 计时器
app.controller("Test", function($scope, $timeout, $window, $uibModal, $log, $http) {
    $scope.rights = new Array;      // 答对的
    $scope.wrongs = new Array;      // 答错的
    $scope.showModal = 0;           // 是否显示交卷对话框
    $scope.showAnswer = 0;          // 是否显示答案
    $scope.submitTitle = "提交中...";    // 提交标题
    $scope.submitDisable = 1;           // 禁用提交按钮
    $scope.info = '正在交卷，请稍等...';                   // 提示信息
    $scope.rightIcon = "glyphicon glyphicon-check text-danger answer-info";    // 小对号

    // 点击发音
    $scope.speak = function(src) {
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
    
    // 用户点选后，进行答案的正确与否判断,并将结果写入正确或错误答案的数组
    $scope.choose = function(wordId, questionId){ 
        var rightIndex = $scope.rights.indexOf(wordId);
        var wrongIndex = $scope.wrongs.indexOf(wordId);

        // 答对
        if (wordId == questionId)
        {
            if (rightIndex == -1) {
                $scope.rights.push(wordId);
            }
            if (wrongIndex !== -1)
            {
                $scope.wrongs.splice(wrongIndex, 1);
            }
        } else {    // 答错
            if (wrongIndex == -1)
            {
                $scope.wrongs.push(wordId);
            }
            if (rightIndex !== -1)
            {
                $scope.rights.splice(rightIndex, 1);
            }
        }
        // 重新计算分值
        setScore();
    }

    // 听写的全部单词初始化
    $scope.writeWords = [<?php foreach($Test->getWriteWords() as $word) echo json_encode($word->getJsonData()) . ','; ?>]; 
    
    // 用户输入单词时触发 判断用户是否输入了正确的单词
    $scope.write = function(word)               
    {   
        var wordId = word.id;
        var rightIndex = $scope.rights.indexOf(wordId);
        var wrongIndex = $scope.wrongs.indexOf(wordId);
        
        if (word.defaultWriteAnswer.trim() == word.title.trim())
        {
            if (rightIndex == -1) {
                $scope.rights.push(wordId);
            }
            if (wrongIndex !== -1)
            {
                $scope.wrongs.splice(wrongIndex, 1);
            }
        } else {    // 答错
            if (wrongIndex == -1)
            {
                $scope.wrongs.push(wordId);
            }
            if (rightIndex !== -1)
            {
                $scope.rights.splice(rightIndex, 1);
            }
        }
        // 重新计算分值
        setScore();
    }

    $scope.totalCount = {:$Test->getTotalCount()};   // 总题数
    $scope.score = 0;                                // 得分

    // 检测单词是否答错，或未答
    $scope.checkIsWrong = function (wordId){
        if ($scope.rights.indexOf(wordId) !== -1)
        {
            return false;
        } else {
            return true;
        }
    };


    $scope.numColor = "green";                      // 倒计时初始化颜色
    var mum = $scope.mum = {:$Test->getTotalMinite() * 60};   // 做答总秒数
    // var mum = $scope.mum = 5;                                 // 测试自定的时间（开发模式）

    // 点击确认后，显示问题正确答案
    $scope.commit = function()
    {
        $('#score').hide();
    }

    // 计算得分
    var setScore = function()
    {
        var score = $scope.rights.length / $scope.totalCount * 100;
        $scope.score = score.toFixed(0);    // 进行四舍五入计算
    }

    // 倒计时
    var timer = function() {
        $timeout(function() {
                $scope.mum--;
                // 时间小于20%，则将字体设置为红色
                if ($scope.mum <= parseInt(mum * 0.2)) {
                    $scope.numColor = "red";
                }
                if ($scope.mum == 0) {
                    if ($scope.showAnswer == 0)
                    {
                        $scope.handPaper(); // 调用自动交卷程序
                    }
                    $('#alert').hide();
                    return;
                }
                timer();
            },
            1000);
    };
    timer();        // 启动计时器


    // 交卷程序
    $scope.handPaper = function()
    {
        var isSelfTest = {:$Test->getJsIsSelfTest()};
        $('#score').show(); // 显示得分对话框
        $('#alert').hide(); // 隐藏提示对话框
        $scope.showAnswer = 1;  // 显示答案

        // 进行$http传输数据
        var url = "{:U('handPaperAjax?id='. $Test->getId())}" + '?grade=' + $scope.score;

        // 如果不是自我测试，则进行数据的提交
        if (isSelfTest == false)
        {
            $http.post(url, {data:{wrongs:$scope.wrongs}})
                .success(function(response){
                    if (typeof(response) !== 'object')
                    {
                        alert("返回数据异常:" + response);
                    }
                    else if (response.status == 'SUCCESS')
                    {
                        success();
                    }
                })
                .error(function(response){
                    alert("系统或网络错误");
                    console.log(response);
            });
        }
        else
        {
            success();
        }
    };

    var success = function ()
    {
        $scope.submitTitle = "确认";    // 提交标题
        $scope.submitDisable = 0;      // 禁用提交按钮
        $scope.info = '交卷成功,点击确认查看做答情况';       // 提示交卷成功
    }

    // 弹出提示框
    $scope.alert = function()
    {
        $('#alert').show();
    };

    // 取消交卷
    $scope.cancel = function(){
        $('#alert').hide();
    };
});

// 去前后空格
String.prototype.Trim = function() 
{ 
    return this.replace(/(\s|&nbsp;)+/g,' ').replace(/\s+/g, ""); 
} 

// 禁止右键
document.oncontextmenu=function(e){return false;}
</script>
