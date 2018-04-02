<script type="text/javascript">
var app = angular.module('yunzhi', ['ui.bootstrap', 'ionic', 'ngAnimate', 'ngCookies']);
app.controller('IndexCtrl', function($scope, Word, $log, $cookieStore, $timeout, $uibModal) {

    //第一次初始化学生设置，cookie信息
    if ($cookieStore.get("index") == undefined) {
        $cookieStore.put("index",{type:"index",checkboxs:[{name:"词汇",function:"indexWordCheck()",checked:true},{name:"美式读音",function:"indexUSCheck()",checked:true},{name:"英式读音",function:"indexUKCheck()",checked:true},{name:"计时器",function:"indexCountsCheck()",checked:true}]});
    }
    if ($cookieStore.get("review") == undefined) {
        $cookieStore.put("review",{type:"review",checkboxs:[{name:"词汇",function:"reviewWordCheck()",checked:true},{name:"计时器",function:"reviewCountsCheck()",checked:true}]});
    }
    if ($cookieStore.get("identify") == undefined) {
        $cookieStore.put("identify",{type:"identify",checkboxs:[{name:"词汇",function:"identifyWordCheck()",checked:true},{name:"音标",function:"identifySymbolCheck()",checked:true},{name:"图片",function:"identifyPictureCheck()",checked:true},{name:"词性解释",function:"identifyExplainsCheck()",checked:true},{name:"中文释义",function:"identifyChineseCheck()",checked:true}]});
    }

    //今天的新学和复习的单词数
    $scope.currentNewWordCount = 0;
    $scope.currentOldWordCount = 0;

    // 获取当前单词
    $scope.word = {:json_encode($Word)},

    $("#mydiv").hide();//初始化的去模板

    //新学，复习实时增加
    $scope.changeCurrentCount = function () {
        if ($scope.word.isNewWord == 1) {
            $scope.currentNewWordCount += 1;
        }else{
            $scope.currentOldWordCount += 1;
        }
    }


    // 判断用户是否完成了本阶段的学习任务
    var getIsDone = function()
    {
        // 这里判断$scope.nextWord的id是否为0
        // 判断用户是否点击的不认识，或是认错。如果最后一个点击不认识或是认错的话，将重复出现该单词
        if (typeof($scope.word) == 'undefined' || $scope.word.id === 0)
        {
            // 加模板
            $("#mydiv").show(); 
            var url = '{:U("review?courseId=" . $Course->getId())}';
            window.location.href = url;
            alert('本阶段学习完毕，点击确定后系统将自动为您跳转');  
            return;
        }
    }

    // 点击认识->认对 认错 拿不准->认错后触发
    // type:0 认识，认对   不重复
    // type:1 认错        重复2次
    // type:2 拿不准->认对 首次重复2次，非首次重复1次
    $scope.changeWord = function (word, type, callback = undefined) {
            $("#mydiv").show();
            console.log('开始获取下一单词');
            getNextWord(word, type, function(word){
                // 判断是否学习完毕，学习完毕，则进行跳转
                getIsDone();
                if (typeof(callback) == 'function') {
                    callback();
                }
                $("#mydiv").hide();
                console.log('获取完毕');
                return;
            })
            
        };

    //取下一个单词
    var getNextWord = function(word, type, callback) {
        Word.getWord(word, type, function(word){
            $scope.word = word;
            console.log(word);
            callback();
        });
    }

    $scope.typeAudio = '';//自动发音类型

    //获取单词信息
    $scope.speak = function(type = null)
    {
        if (type === null) {
            type = $scope.typeAudio;
        }
        Word.speak($scope.word, type);
    }



    //获取子C的checkbox信息
    $scope.$on('to-parent',function (event,data) {
        $scope.checkboxs = data;

        //index遍历赋值
        $scope.checkboxs.checkboxs.forEach(function (event) {
            if (event.function == "indexWordCheck()") {
                if (event.checked == true) {
                    $scope.indexShowWord = 1;
                } else {
                    $scope.indexShowWord = 0;
                }
            }
            if (event.function == "indexUKCheck()") {
                if (event.checked == true) {
                    $scope.indexUK = 1;
                    $scope.typeAudio = "uk";
                    $scope.speak('uk');
                } else {
                    $scope.indexUK = 0;
                }
            }
            if (event.function == "indexUSCheck()") {
                if (event.checked == true) {
                    $scope.indexUS = 1;
                    //默认发英音
                    //只勾选美音，自动发美音
                    if($scope.indexUK == 0){
                        $scope.typeAudio = "us";
                        $scope.speak('us');
                    }
                } else {
                    $scope.indexUS = 0;
                }
            }
            if (event.function == "indexCountsCheck()") {
                if (event.checked == true) {
                    $scope.indexCounts = 1;
                } else {
                    $scope.indexCounts = 0;
                }
            }
            //review遍历赋值
            if (event.function == "reviewWordCheck()") {
                if ($scope.typeAudio != undefined) {
                    $scope.speak($scope.typeAudio);//选择界面自动发音
                }
                if (event.checked == true) {
                    $scope.reviewShowWord = 1;
                } else {
                    $scope.reviewShowWord = 0;
                }
            }
            if (event.function == "reviewCountsCheck()") {
                if (event.checked == true) {
                    $scope.reviewCounts = 1;
                } else {
                    $scope.reviewCounts = 0;
                }
            }

            //identify遍历赋值
            if (event.function == "identifyWordCheck()") {
                if (event.checked == true) {
                    $scope.identifyShowWord = 1;
                } else {
                    $scope.identifyShowWord = 0;
                }
            }
            if (event.function == "identifySymbolCheck()") {
                if (event.checked == true) {
                    $scope.identifySymbol = 1;
                } else {
                    $scope.identifySymbol = 0;
                }
            }
            if (event.function == "identifyPictureCheck()") {
                if (event.checked == true) {
                    $scope.identifyPicture = 1;
                } else {
                    $scope.identifyPicture = 0;
                }
            }
            if (event.function == "identifyExplainsCheck()") {
                if (event.checked == true) {
                    $scope.identifyExplains = 1;
                } else {
                    $scope.identifyExplains = 0;
                }
            }
            if (event.function == "identifyChineseCheck()") {
                if (event.checked == true) {
                    $scope.identifyChinese = 1;
                } else {
                    $scope.identifyChinese = 0;
                }
            }
        });
    });


    //保存cookie信息
    var saveCookie = function (value) {
        $scope.checkboxs.checkboxs.forEach(function (event) {
            if (event.function == value) {
                event.checked == !event.checked;
            }

        });
        if ($scope.checkboxs.type == "index") {
            $cookieStore.put("index",$scope.checkboxs);
        }
        if ($scope.checkboxs.type == "review") {
            $cookieStore.put("review",$scope.checkboxs);
        }
        if ($scope.checkboxs.type == "identify") {
            $cookieStore.put("identify",$scope.checkboxs);
        }
    }

    //index页面元素用到的click方法
    //单词
    $scope.indexWordCheck = function(){
        $scope.indexShowWord = !$scope.indexShowWord;
        saveCookie("indexWordCheck()");
    };
    //英式发音
    $scope.indexUKCheck = function(){
        $scope.indexUK = !$scope.indexUK;
        saveCookie("indexUKCheck()");
    };
    //美式发音
    $scope.indexUSCheck = function(){
        $scope.indexUS = !$scope.indexUS;
        saveCookie("indexUSCheck()");
    };
    //计时器
    $scope.indexCountsCheck = function(){
        $scope.indexCounts = !$scope.indexCounts;
        saveCookie("indexCountsCheck()");
    };

    //review页面元素用到click方法
    $scope.reviewWordCheck = function(){
        $scope.reviewShowWord = !$scope.reviewShowWord;
        saveCookie("reviewWordCheck()");
    };
    $scope.reviewCountsCheck = function(){
        $scope.reviewCounts = !$scope.reviewCounts;
        saveCookie("reviewCountsCheck()");
    };

    //identify页面元素用到click方法
    //单词
    $scope.identifyWordCheck = function(){
        $scope.identifyShowWord = !$scope.identifyShowWord;
        saveCookie("identifyWordCheck()");
    };
    //音标
    $scope.identifySymbolCheck = function(){
        $scope.identifySymbol = !$scope.identifySymbol;
        saveCookie("identifySymbolCheck()");
    };

    //图片
    $scope.identifyPictureCheck = function(){
        $scope.identifyPicture = !$scope.identifyPicture;
        saveCookie("identifyPictureCheck()");
    }

    //词性解释
    $scope.identifyExplainsCheck = function(){
        $scope.identifyExplains = !$scope.identifyExplains;
        saveCookie("identifyExplainsCheck()");
    }

    //中文释义
    $scope.identifyChineseCheck = function(){
        $scope.identifyChinese = !$scope.identifyChinese;
        saveCookie("identifyChineseCheck()");
    }
    //注释音节
    // $scope.syllableCheck = function(){
    //     $scope.syllable = !$scope.syllable;
    //     saveCookie("syllableCheck()");
    // };
     
      document.onkeydown = function (e) {
        if (e.keyCode == 17) {
            $scope.speak($scope.typeAudio);
        }
    }

    // 弹出 modal. size: lg大，sm小, 不传值为默认大小
    // 参考：https://angular-ui.github.io/bootstrap/
    var openModal = function (size) {
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'alertFatigue.html',
            controller: 'alertFatigue',
            size: size,
            resolve: {
                items: function () {
                    return $scope.items;
                }
            }
        });
    };

    // 到达设定时间后，弹出休息一下的对话框
    $timeout(function(){
        openModal('lg');
    }, {$Student->getIndexOfFatigue()->getValueMs()});
});

</script>
