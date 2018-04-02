<script type="text/javascript">
var app = angular.module('myapp', ['ui.bootstrap', 'ionic']);
app.controller("WordDetailCtrl", function($scope, $uibModal) {

    $scope.word = {:json_encode($word->getJsonData())};
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
            controller: 'WordDetailCtrl',
            size: 'sm',
            resolve: {
                items: function() {
                    return $scope.items;
                }
            }
        });

        modalInstance.result.then(function(selectedItem) {
            $scope.selected = selectedItem;
        }, function() {
            $log.info('Modal dismissed at: ' + new Date());
        });
    };

    $scope.cancel = function() {
        $uibModalInstance.dismiss('cancel');
    };

    $scope.lastword = function(value) {
        
        alert($scope.StarWords);
    }

});
</script>
