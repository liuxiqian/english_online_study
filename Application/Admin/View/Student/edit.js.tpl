<script>
app.controller("edit", function($scope) {
    $scope.phonenumber = "{$M->getStudentPhonenumberByStudentId($studentId)}";
    $scope.regex = "^0?1[0-9]{10}$"; //手机号码的验证
})
</script>
