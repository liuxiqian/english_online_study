
<script>
var app = angular.module("Home", ['ui.bootstrap', 'ngAnimate']);
app.controller("index",function($scope, $uibModal, $log){
    $scope.newCount = {:$StudentCourse->getNewStudyWordsCount()};  // 新学
    $scope.oldCount = {:$Course->getOldStudyWordsCount($Student)};  // 复习
    $scope.totalCount = {:$Course->getWordCount()};                 // 总单词数
    $scope.process = parseInt($scope.newCount * 100 / $scope.totalCount); // 进度
    $scope.process = $scope.process > 100 ? 100 : $scope.process;   // 防止大于100的泄露
    
    // 获取第一单词 ,如果不存在，则给一个默认单词
    <?php if(!isset($nWords[0])) $nWords[0] = new \Home\Model\Word(); ?>
    $scope.word = {:json_encode($nWords[0]->getJsonData());};

  	$scope.english = 1;
  	$scope.chinese = 1;
  	$scope.exampleWord = 0;   //近义词和反义词
  	$scope.relationPicture = 1; //右侧关系图

    /**
     * 根据起始点获取进度条
     * @param  {int} begin 开始
     * @param  {int} end   结束点
     * @return {int}       进度条长度
     */
    $scope.getProccess = function (begin, end)
    {
        if ($scope.process - end > 0)
        {
            return end - begin;
        }
        else
        {
            return $scope.process - begin > 0 ? $scope.process - begin : 0;
        }
    }

	$scope.example = function(){
		$scope.exampleWord = !$scope.exampleWord;
	}

	$scope.relation =function() {
		$scope.relationPicture = !$scope.relationPicture;
	}
	$scope.model = function(val1,val2) {
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

	$scope.open = function () {

    var modalInstance = $uibModal.open({
      animation: $scope.animationsEnabled,
      templateUrl: 'myModalContent.html',
      controller: 'wordDetail',
      size: 'sm',
      // resolve: {
      //   items: function () {
      //     return $scope.items;
      //   }
      // }
    });

    modalInstance.result.then(function (selectedItem) {
      $scope.selected = selectedItem;
    }, function () {
      $log.info('Modal dismissed at: ' + new Date());
    });
  };

   $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

  $scope.openModal = function(url){
      var modalInstance = $uibModal.open({
        animation: true,
        template: beforeTestInfo,
        controller: 'testInfo',
        size: 'md',
        resolve: {
          url: function() {
            return url;
          }
        }
      });
  };
  var beforeTestInfo = '<div class="modal-body"><div class="row"><div class="col-md-10 col-md-push-1 text-center"><h4 style="color:#000">在正式爆破你的词汇之前，请参加学前测试，测试结果将有助于我们了解你对本教材词汇的掌握情况。</h4></div></div><hr /><div class="text-center"><a class="btn btn-md btn-warning" href="{{url}}">进行学前测试</a></div></div>';

});

app.controller('testInfo', function($scope, $uibModalInstance, url){
  $scope.url = url;
});
</script>