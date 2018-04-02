<!--
    词汇管理 
    panjie
    2016.04.11
-->
<script type="text/javascript">
    var app = angular.module('body', ['ngFileUpload']);
    app.controller('index',function($scope, Upload, $http, $timeout){
        $scope.data = {$M->getJsonList() | json_encode};
        $scope.data.explains = {$M->getExplains() | json_encode};
        $scope.data.attachment_url = "{$M->getAttachmentUrl()}";
        $scope.data.audios = {$Word->getAudios() | json_encode};

        $scope.alert = '';          // 提示信息

        // 监视音频文件是否产生了变化,分别设置显示字体及样式
        $scope.$watch('data.audios', function(){
            setTipsAndShowClass();
        });

        // 设置提示和class值
        var setTipsAndShowClass = function(){
            $scope.data.audios.uk.tips = $scope.data.audios.uk.fileExist == false ? '未抓取' : '已抓取';
            $scope.data.audios.uk.showClass = $scope.data.audios.uk.fileExist == false ? 'text-danger' : 'text-success';

            $scope.data.audios.us.tips = $scope.data.audios.us.fileExist == false ? '未抓取' : '已抓取';
            $scope.data.audios.us.showClass = $scope.data.audios.us.fileExist == false ? 'text-danger' : 'text-success'; 
        };

        // upload on file select or drop
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

        /**
         * 上传音频文件
         * @param  {file} file 上传的文件
         * @param  {类型} type uk:英式读音 us:美式读音
         * @return {[type]}      
         * @author panjie
         */
        $scope.uploadAudio = function (file, type) {
            if (file)
            {
                Upload.upload({
                    url: '{:U("uploadAudioAjax")}' + '?type=' + type + '&title=' + $scope.data.title,
                    data: {yunzhifile: file}
                }).then(function (resp) {
                    if (resp.data.state === "ERROR")
                    {
                        alert("系统错误:"+resp.data.message);
                    }
                    else
                    {   
                        // 按类别来分别重置是存存在音频文件的状态
                        if (type === 'us')
                        {
                            $scope.data.audios.us.fileExist = true;
                        } else {
                            $scope.data.audios.uk.fileExist = true;
                        }
                        // 重新生成提示信息
                        setTipsAndShowClass();

                        // 生成alert信息
                        $scope.alert = '上传成功';
                        $timeout(function(){
                            $scope.alert = '';
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

        //进行单词查询
        var query = function(word){
            $http(
            {
                url:"{:U('queryWordAjax')}?word="+word,
                method:'get'}
            )
            .then(function (response){
                console.log(response);
                //查询出错，则直接返回
                if (typeof(response.data) === 'string')
                {
                    return;
                }
                else
                {
                    $scope.data.translation = response.data.translation;
                    $scope.data.us_phonetic = response.data.basic['us-phonetic'];
                    $scope.data.uk_phonetic = response.data.basic['uk-phonetic'];
                    $scope.data.explains = response.data.basic.explains;
                }
            }, function(response){
                return;
            });
        }; 

        //加减词性
        $scope.changeExplain = function(explain, $index)
        {
            if ($index)
            {
                $scope.data.explains.splice($index,1);
            }
            else
            {
                try
                {
                    $scope.data.explains.push("");
                }
                catch(error)
                {
                    return;
                }

            }
        }

        $scope.query = function ()
        {
            query($scope.data.title);
        };
    });

    //添加单词扩展信息的HTML文本
    var wordNatureHtml = '<div class="row wordNature"><select name="word_nature_id[]"><foreach name="M:getWordNatureLists()" item="wordNature"><option value="{$wordNature["id"]}">{$wordNature["name"]}</option></foreach></select> <input type="text" name="word_word_nature_title[]" value="" />&nbsp;释义:<input type="text" name="word_word_nature_explain[]" value=""/> <button class="subNature" type="button">-</button></div>';

    //移除单词扩展信息
    var subNature = function(){
        $(this).parent().remove();
    }
    var addNature = function(){
        $('#wordNatures').append(wordNatureHtml);
        $(".subNature").on("click", subNature);
    }
    $(".subNature").on("click", subNature);
    $(".addNature").on("click", addNature);
</script>