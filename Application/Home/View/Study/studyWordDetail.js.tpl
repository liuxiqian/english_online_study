<script type="text/javascript">
app.controller("WordDetailCtrl", function($scope, $uibModal, $log, $http, $location, $stateParams, Word, $timeout, $document) {
    var action = '{$action}';
    //$type === 1（认识->认错；不认识；拿不准->认错）
    //$type === 2（拿不准->认对）
    var type = $stateParams.type;
    $scope.info = '点击添加至生词本';

    // 拿不准、认错、不认识，统一为其它
    $scope.skip = function (word) {
        var random = Math.floor(Math.random()*10);

        // 如果为复习单词，则70%的概率进入复习单词选择正确的答案的界面
        if(random > 3 && $scope.word.isNewWord != 1){
            $location.path('half/review');

        // 获取下一个单词
        } else {
            $scope.changeWord(word, 'unknow', function(){
                //新学复习自动加1
                $scope.changeCurrentCount();
                $location.path('half/index');
            });
        }

        return;
    }

    $document.bind("keypress", function(event) {
        $scope.$apply(function (){
            if (event.keyCode == 39) {
                $scope.skip($scope.word.id);
            }
        })
    });

    //加入生词本
    $scope.addNewWord = function () {
        $scope.info = '正在添加';
        Word.addNewWord($scope.word.id, function(){
            $scope.info = '操作成功';
            $timeout(function() {
                $scope.info = '点击添加至生词本';
                return;
            }, 1500);
        });
    }

    $scope.english = 1;
    $scope.chinese = 1;
    $scope.exampleWord = 0; //近义词和反义词
    $scope.relationPicture = 1; //右侧关系图
    $scope.example = function() {
        $scope.exampleWord = !$scope.exampleWord;
    }

    $scope.relation = function() {
        $scope.relationPicture = !$scope.relationPicture;
    }
    $scope.model = function(val1, val2) {
        //隐藏中文
        if (val1 == 1 && val2 == 1) {
            $scope.english = 1;
            $scope.chinese = 0;
        }
        //隐藏英文显示中文
        if (val1 == 1 && val2 == 0) {
            $scope.english = 0;
            $scope.chinese = 1;
        }
        //全都显示
        if (val1 == 0 && val2 == 1) {
            $scope.english = 1;
            $scope.chinese = 1;
        }
    }

    $scope.open = function() {

        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            size: 'sm',
            scope:$scope,
            resolve: {
            }
        });

        modalInstance.result.then(function() {
            console.log('then');
        }, function() {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };
});

// 练一练小对话框
app.controller('ModalInstanceCtrl', function($scope, $uibModalInstance){
    var word = $scope.word;
    var title = word.title.Trim();
    $scope.exercise = '';
    $scope.right = false;
    $("#exercise").focus();
    $scope.change = function(){
        if ($scope.exercise.Trim() == title)
        {
            $scope.right = true;
        }
    };

    // 再练一次
    $scope.repeat = function () {
        $scope.exercise = '';
        $scope.right = false;
    };  

    // 取消
    $scope.cancel = function() {
        $uibModalInstance.dismiss();
    };

});

// 去前后空格
String.prototype.Trim = function() 
{ 
    return this.replace(/\s+/g, ""); 
} 

// 检测用户是否按下回车键
app.directive('myEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.myEnter);
                });

                event.preventDefault();
            }
        });
    };
});
</script>
