<!--单词Word-->
<script type="text/javascript">
app.factory("Word", function($http, $q){
    var getStudyWord =  function(word, type = 'know', callback = undefined) {
        var url = '{$url}';
                
        $http.get(url, {
            params: {
                wordId: word.id,
                courseId: {$StudentCourse->getCourse()->getId()},
                type:type,
                testId: {$Test->getId()},
                isNew: word.isNewWord,
            }
        })
        .success(function(response) {
            if (response.status == 'SUCCESS') {

                if (typeof(callback) === 'function')
                {
                    callback(response);
                } else {
                    return response.data;
                }
            } else {
                alert(response.message);
            }
        })
        .error(function(response) {
            alert("系统或网络错误");
        });
    };

    return{
        getWord: function(word, type = 'know', callback = undefined){
            getStudyWord(word, type, function(response){
                if (typeof(callback) === 'function') {
                    callback(response.data);
                }
            }); 
        },
        // 获取学习界面中 右侧边栏的数据
        getStudyList:function () {
            var lastNewWordCount = 0;  //上次那天新学单词数
            var lastOldWordCount = 0; //上次那天复习单词数
            var lastStudyTime = 0; //上次那天的学习时长
            var lastBeginTime = 0;//上次那天的开始学习时间
            var totalStudyTime = 0;    //这门课程的累计学习时间
            var courseProgress = 0;    //这门课程的学习进度
            if (lastStudyTime > totalStudyTime) {
                lastStudyTime = totalStudyTime;
            }
            return{
                "lastNewWordCount"      : lastNewWordCount,
                "lastOldWordCount"      : lastOldWordCount,
                "lastStudyTime"         : lastStudyTime,
                "lastBeginTime"         : lastBeginTime,
                "totalStudyTime"        : totalStudyTime,
                "courseProgress"        : courseProgress,
            }
        },
        addNewWord: function(wordId, callback = undefined){
            return addNewWord(wordId,$http,callback);
        },
        speak:speak,
    };
});
</script>
<include file="Factory.addNewWord.js" />
<include file="Factory.speak.js" />