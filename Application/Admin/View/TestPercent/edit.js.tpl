<script type="text/javascript">
app.controller("testPercent", function($scope) {
    // 绑定验证
    $scope.percent = {:$Test->getPercent()}; //默认值百分比为50%
    $scope.explainCount = {:$Test->getExplainCount()};//取释义题数
    $scope.listeningCount = {:$Test->getListeningCount()};//取听辩题数
    $scope.writeCount = {:$Test->getWriteCount()};//取听写题数
    $scope.totalMinite = {:$Test->getTotalMinite()};    // 测试时长
})
</script>
