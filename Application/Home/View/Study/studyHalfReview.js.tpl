<script type="text/javascript">
app.controller('StudyHalfReviewCtrl', function($scope, $timeout, $interval,$location,$log, $state, Word, $cookieStore, $document) {

    //取review页面的学生设置信息
    var reviewCheckboxs = $cookieStore.get("review");
    $scope.$emit('to-parent',reviewCheckboxs);

    //判断是否熟悉
    if ($scope.word.isNewWord === 3) {
        $scope.isNewWord = 0;
    }else{
        $scope.isNewWord = 1;
    }

    // 计时器
    $scope.count = 5;
    $interval(function() {
        if ($scope.count > 0) {
            $scope.count = $scope.count - 1;
        }
    }, 1000);

    $scope.info = "";

    //加入生词本
    $scope.addNewWord = function () {
        Word.addNewWord($scope.word.id, function(){
            $scope.info = "成功加入生词本";
            $timeout(function() {
                $scope.info = '';
            }, 1500);
        });
    }

    $scope.skip = function (word) {
        // var random = Math.floor(Math.random()*10);
        // if(random < 5 && $scope.nextWord.isNewWord != 1){
        //     if ($scope.selectId == wordId) {
        //         $scope.changeWord(wordId,0);
        //     }
        //     else{
        //         $scope.changeWord(wordId,1);
        //     }
        //     //新学复习自动加1
        //     $scope.changeCurrentCount();

        //     //刷新当前部分路由
        //     $log.debug($state.current);
        //     $state.reload();

        // }
        

        // 获取下一个单词
        $scope.changeWord(word, 'unknow', function(){
            //新学复习自动加1
            $scope.changeCurrentCount();
            $location.path('half/index');
        });    
    }

    // 点击正确选项出现对号错号
    $scope.disabled = false;
    $scope.nextButton = false; //下一个单词的按钮


    $scope.judge = function (id,value) {

        //如果选对就显示点击选项前面的对号
        if ($scope.word.id == id) {
            $("#question"+value+"-true").show();
        }
        else{
            //否则就是显示点击选项前面的错号和后面的加入生词本标记
            $("#question"+value+"-false").show();
            $("#word"+value).show();

            //循环随机数组，提示学生正确的选项，显示其前面的对号
            $scope.word.randomQuestionWords.forEach(function(element, index){
                if ($scope.word.id == element.id) {
                    $("#question"+index+"-true").show();
                }
            });
        }
        $scope.disabled = true;//选项只可点击一次
        $scope.nextButton = true;//显示下一个单词按钮
        $scope.selectId = id;
    }

    //65,66,67,68对应键盘a,b,c,d
    document.onkeydown = function (e) {
        if (e.keyCode == 65) {
            $scope.judge($scope.word.randomQuestionWords[0].id,0);
        }
        if (e.keyCode == 66) {
            $scope.judge($scope.word.randomQuestionWords[1].id,1);
        }
        if (e.keyCode == 67) {
            $scope.judge($scope.word.randomQuestionWords[2].id,2);
        }
        if (e.keyCode == 68) {
            $scope.judge($scope.word.randomQuestionWords[3].id,3);
        }
        if ($scope.nextButton === true) {
            if (e.keyCode == 39) {
                $scope.skip($scope.word.id);
            }
        }
        //按ctrl键发音
        if (e.keyCode == 17) {
            $scope.speak($scope.typeAudio);
        }
    }

    // console.log($scope.word.randomQuestionWords[0].id);
    // $document.bind("keypress", function(event) {
    //         if (event.keyCode == 65) {
    //             $scope.judge($scope.word.randomQuestionWords[0].id,0);
    //         }
           
    // });
});
</script>
