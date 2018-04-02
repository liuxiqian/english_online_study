 <script type="text/javascript">
    app.controller("add", function($scope, Upload){
    	$scope.order__customer_id = "{$list['order__customer_id']}";
        $scope.data = {$list | json_encode};
        if ($scope.data != null) {
            $scope.data.attachment_url = {$url | json_encode};
        }

        if ($scope.order__customer_id != "")
		{
			$scope.isuser = 1;
			$scope.showspan = 1;
		}
		else
		{
			$scope.isuser = 0;
			$scope.showspan = 0;
		}

        $scope.submit = function(){
            return false;
        }

        $scope.upload = function (file) {

            if (file)
            {
                Upload.upload({
                    url: '{:U("uploadAjax")}',
                    data: {yunzhifile: file}
                }).then(function (resp) {
                    if (resp.data.state === "ERROR")
                    {
                        alert("系统错误:"+resp.data.message);
                    }
                    else
                    {
                        $scope.data.attachment_id = resp.data.id;
                        $scope.data.attachment_url = resp.data.url;
                    }
                    console.log(resp);
                }, function (resp) {
                    alert("系统未成功返回信息");
                }, function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                });
            }
            
        };
    })
 </script>