<script type="text/javascript">
var app = angular.module('mengyunzhi', ['ui.bootstrap','ngAnimate']);

app.controller("vocabulary",function($scope,  $http, $timeout)
{
    // 单词列表, 为了防止js代码混乱引起的IDE自动格式检查错误，使用php嵌套的方法
    $scope.words = [
    <?php
        foreach($words as $word)
            echo json_encode($word->getJsonData()) . ',';
    php?>
    ];  

    $scope.info = '';

    // 播放音频文件
    $scope.play = function(word){
        if (window.HTMLAudioElement) {
            try {
                var Audio = document.getElementById('audio');
                Audio.src = word.audioUkUrl;
                Audio.play();
            } catch (e) {
                if (window.console && console.error("Error:" + e));
            }
        }
    };
    // 是否显示全部
    $scope.showExplain = false;
    $scope.showTitle   = true;

    // 查看/隐藏所有释义
    $scope.toggleAll = function(type)
    {
        if (type == 'title')
        {
            $scope.showTitle = !$scope.showTitle;
            $scope.words.forEach(function(element){
                element.showTitle = $scope.showTitle;
            });
        }
        else
        {
            $scope.showExplain = !$scope.showExplain;
            $scope.words.forEach(function(element){
                element.showExplain = $scope.showExplain;
            });
        }

    }

    // 显示、隐藏释义
    $scope.toggleExplain = function (word, type="title")
    {
        if (type == 'title')
        {
            word.showTitle = !word.showTitle;
        }
        else
        {
            word.showExplain = !word.showExplain;
        }
    };

    //删除生词
    // 删除程序
    $scope.handPaper = function()
    {
        $('#score').show();
        $('#alert').hide();
        
    }

    // toggle扩展信息
    $scope.showExtends = function(word)
    {
        if (word.show)
        {
            word.show = false;
        } else
        {
            word.show = true;
        }
    }

    // 动画效果
    var animateArray = [
            "toggle",
            "spin-toggle",
            "slide-left",
            "slide-right",
            "slide-top",
            "slide-down",
            "bouncy-slide-left",
            "bouncy-slide-right",
            "bouncy-slide-top",
            "bouncy-slide-down",
            "scale-fade",
            "scale-fade-in",
            "bouncy-scale-in",
            "flip-in",
            "rotate-in"];

    // 打乱数组
    var shuffle = function (a) {
        var j, x, i;
        for (i = a.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }
    }

    shuffle(animateArray);

    // 获取随机效果
    $scope.randAnimate = function(index) {
        index = Math.round(index%animateArray.length);
        return animateArray[index]
    }

    // 删除生词
    $scope.remove = function(word)
    {
        $http.get('{:U("NewVocabulary/delete")}',{params:{id:word.id}})
            .success(function(response){
                console.log(response);
                if (response.status == 'SUCCESS')
                {
                    for (var key in $scope.words)
                    {
                        if ($scope.words[key].id == word.id)
                        {
                            $scope.words.splice(key,1);
                            $scope.info = word.title + " 已移出生词本";
                            $timeout(function() {
                                $scope.info = '';
                                return;
                            }, 1500);
                        }
                    }
                }
                else{
                    alert(response.data);
                }
            })
            .error(function(response){
                alert("系统或网络错误");
                console.log(response);
        });
    }

    // 添加生词
    $scope.add = function(word){
        $http.get('{:U("Vocabulary/addToNewWordAjax")}',{params:{id:word.id}})
            .success(function(response){
                console.log(response);
                if (response.status == 'SUCCESS')
                {
                    $scope.info = word.title + " 已成功添加至生词本";
                    $timeout(function() {
                        $scope.info = '';
                        return;
                    }, 1500);
                }
                else{
                    alert(response.data);
                }
            })
            .error(function(response){
                alert("系统或网络错误");
                console.log(response);
        });
    };
});
</script>