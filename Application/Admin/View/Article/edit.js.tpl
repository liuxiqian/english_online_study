<script type="text/javascript">
    var app = angular.module('body', ['ngFileUpload']);
    app.controller('articleEdit', function($scope, Upload, $http, $timeout){
        $scope.showPlayer = false;  // 是否显示播放器
        $scope.showPlay = false;    // 是否显示播放按钮
        $scope.info = '';

        $scope.audio = {}; // 音频信息
        $scope.audio.id = {$Article->getAttachment()->getId()};        //id

        // 监测音频是否发生变化
        $scope.$watch('audio.id', function(){
            if ($scope.audio.id == 0)
            {
                $scope.showPlay = false;
            } else {
                $scope.showPlay = true;
            }
        });


        $scope.audio.src = "{$Article->getAttachment()->getAudioUrl()}";

        // 播放音频文件
        $scope.togglePlay =  function(){
            $scope.showPlayer = true;
            togglePlay('audio', $scope.audio.src);
        };

        /**
         * 上传音频文件
         * @param  {file} file 上传的文件
         * @return state: SUCCESS|ERROR  
         * @author panjie
         */
        $scope.uploadAudio = function (file) {
            if (file)
            {
                pauseAudio('audio'); // 暂停当前播放
                Upload.upload({
                    url: '{:U("uploadAudioAjax")}',
                    data: {yunzhifile: file}
                }).then(function (resp) {
                    console.log(resp);
                    if (resp.data.state === "ERROR")
                    {
                        alert("系统错误:"+resp.data.message);
                    }
                    else
                    {
                        // 生成alert信息
                        $scope.info = '上传成功';
                        $scope.audio.id = resp.data.id;
                        $scope.audio.src = resp.data.url;
                        $scope.showPlayer = false;  // 是否显示播放器
                        $scope.showPlay = true;    // 是否显示播放按钮
                        $timeout(function(){
                            $scope.info = '';
                        }, 1500);
                    }
                    console.log(resp);
                }, function (resp) {
                    alert("系统未成功返回信息");
                }, function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                });

            }
        };

    });
</script>