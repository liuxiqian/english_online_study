<script>
 $(document).ready(function(){
  $('.datetimepicker').datetimepicker({
    autoclose: true,
    todayBtn: true,
    
    minView:2

  });
});
 app.controller('addTest', function($scope, $http){
    $scope.load = 1;
    $scope.disabled = 0;

    $scope.excel = function() {
        $scope.disabled = 1;
         $http.get('{:U("Test/excelAjax")}')
        .success(function(data,status){
            $scope.disabled = 0;
            if (data.status === "SUCCESS") {
                $scope.load = 0;
            }
            else{
                alert(data.message);
            }
        })
       .error(function(data,status){
            alert("系统或网络错误");
            console.log(data);
       });
    }
})
</script>