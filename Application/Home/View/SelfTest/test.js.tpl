<script type="text/javascript">
var app = angular.module('myApp', ['ngAnimate']);


app.filter("secondFormat",function(){
                return function(second){
                   return second * 1;
               }
            });
app.controller("WordTest",function($scope,$timeout){
   $scope.mum = 120;
   var timer =  function  () {
   $timeout(function() {
      
      $scope.mum--;
      timer();
        },
        1000);
   }
      timer();
});
</script>