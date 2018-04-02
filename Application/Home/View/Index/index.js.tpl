<script type="text/javascript">
var app = angular.module('myApp', ['ngAnimate']);
app.controller("MyCourse",function($scope){
    $scope.showStudingCourse = false;
    $scope.showAllCourse = true;
	$scope.myCheck = 1;
	$scope.allClass = function(){

	$scope.myCheck = !$scope.myCheck;
}
	
});
</script>