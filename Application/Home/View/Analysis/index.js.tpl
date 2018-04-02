<script>
(function (ChartJsProvider) {
  ChartJsProvider.setOptions({ colors : [ '#cxxccc', '#00ADF9', '#DCDCDC', '#46BFBD', '#FDB45C', '#949FB1', '#aaaaa'] });
}); 

$(document).ready(function(){
  $('.datetimepicker').datetimepicker({
    autoclose: true,
    todayBtn: true,
    minView:2
  });
});
var app = angular.module('analysis', ['chart.js']);
app.controller("LineCtrlTime", function($scope) {
    $scope.labels = [
        <?php for($i = 1;$i <= $DayStudyTime->getTotalDays();$i++):?>
        <?php echo $i.','  ?>
        <?php endfor;?>
    ];
    $scope.data = [
        [
           <?php 
            foreach($DayStudyTime->getCurrentMonthAllLists() as $dayStudyTime) 
                echo $dayStudyTime->getMinute().',';
            php?>
        ]
    ];
});

app.controller('LineCtrlAmount', function($scope) {
    $scope.labels = [
        <?php for($i = 1;$i <= $DayStudyCount->getTotalDays();$i++):?>
        <?php echo $i.','  ?>
        <?php endfor;?>
    ];
    $scope.data = [
        [
            <?php 
            foreach($DayStudyCount->getCurrentMonthAllLists() as $DayStudyCount) 
                echo $DayStudyCount->getCount().',';
            php?>
        ]
    ];
});
app.controller('BarCtrlGrade', function($scope) {
    $scope.labels = [
        <?php for($i = 1;$i <= $DayGrade->getTotalDays();$i++):?>
        <?php echo $i.','  ?>
        <?php endfor;?>
    ];

    $scope.series = {
        title: ['学前', '组测', '阶段'],
        colors: ['#ff0000', '#00ff00', '#0000ff']
    };

    $scope.data = [
        [
            <?php foreach($DayGrade->getCurrentMonthAllLists() as $dayGrade):?> 
                <?php echo $dayGrade->getBeforeTestGrade().','?>
            <?php endforeach;?>
        ],
        [
            <?php foreach($DayGrade->getCurrentMonthAllLists() as $dayGrade):?> 
                <?php echo $dayGrade->getGroupTestGrade().','?>
            <?php endforeach;?>
        ],
        [
            <?php foreach($DayGrade->getCurrentMonthAllLists() as $dayGrade):?> 
                <?php echo $dayGrade->getStageTestGrade().','?>
            <?php endforeach;?>
        ]
    ];
});
</script>