<script type="text/javascript">
    app.controller('articleIndex', function($scope, $http, $timeout){
        // 初始化班级ID、闯关列表，提示信息
        var klassId = {:$Klass->getId()};
        $scope.articles = {$articles | json_encode};
        $scope.info = '';

        // 用户点击时进行ajax传值
        $scope.save = function(article){
            var url = "{:U('articleSaveAjax')}";
            $http.get(
                url,
                {
                    params:{'article_id': article.id, klass_id:klassId}
                }
            )
            .success(function(res){
                $scope.info = '操作成功';
                $timeout(function(){
                    $scope.info = '';
                }, 1500);
                console.log(res);
            })
            .error(function(res){
                alert('数据错误' + res);
            })
            ;
        };
    });
</script>