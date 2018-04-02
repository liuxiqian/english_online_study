<script>
var myapp = angular.module("myapp", ['ui.bootstrap', 'ngAnimate']);
myapp.controller('LinkLookHome', function($scope, $interval, $timeout, $http, $uibModal){
    /**
     * 1.http获取8随机单词
     * 2.加上释义混合成16
     * 3.前台循环输出
     * 4.点击判断是否相同
     */
    $scope.laba = "glyphicon glyphicon-volume-up";
    var audioElm = document.getElementById("audio1");
        audioElm.src = "__ROOT__/audio/"+"croatia.mp3"; // 添加播放文件
        audioElm.play(); // 播放
    $scope.playAudio = function () {
        console.log("__ROOT__");
        if (audioElm.paused == true) {
            audioElm.play();  // 播放
            $scope.laba = "glyphicon glyphicon-volume-up";
        } else {
            audioElm.pause(); // 暂停
            $scope.laba = "glyphicon glyphicon-volume-off";
        }
    }


    var words = [];
    var courseId = "{:I('get.courseId')}";

    var getwords = function () {
        $http.get("{:U('Game/getLinkLookWordsAjax')}",{params:{count:'8',courseId:courseId}})
       .success(function(data,status){
            console.log(data);
            words = data;
            //平均分成4个数组
            $scope.results = [];
            for(var i=0,len=words.length;i<len;i+=4){
               $scope.results.push(words.slice(i,i+4));
            }
            console.log($scope.results);
        })
       .error(function(data,status){
            
       });
    };

    getwords();

$scope.picUrl = "";//笑脸哭脸的地址
$scope.myCheck = 0;
$scope.right = 0;//选对个数
$scope.error = 0;//选错个数
$scope.time  = 180;//倒计时100秒
var a = [];//已经反转的
var b = [];//临时点击的

//倒计时
$interval(function() {
    if ($scope.time > 0) {
        $scope.time--;
    }
    if ($scope.time == 0) {
        openModal("sm");
        $interval.cancel(stop);
    }
}, 1000);

//定义笑脸哭脸的时间
var wait = function () {
    $timeout(function(){
        $scope.myCheck = 0;
    }, 500);
}

//游戏点击的操作
$scope.look = function (value) {
    
    //判断临时数组b是否有值
    //没有，把当前的点击的push进去
    if (b.length == 0) {
        $(".pic-"+value.num+" .back").addClass("col");
        value.index = value.num;
        b.push(value);
        console.log(b);
        return;
    }

    //b不为空，判断里面的值与当前点击的是否匹配（id是否相同，不能是自己）
    if (b[0].id != value.id || b[0].name == value.name) {
        //取消鼠标滑动特效
        $(".pic-"+b[0].index+" .back").removeClass("col");
        b = [];
        $scope.error++;

        //弹出哭脸
        $scope.picUrl = "__IMG__/cry.png";
        $scope.myCheck = 1;
        wait();

        return;
    }

    //相等，removeClass,清空b,push进a
    $(".pic-"+value.num).removeClass("reversal");
    $(".pic-"+b[0].index).removeClass("reversal");
    a.push(b[0]);
    a.push(value);
    b = [];
    $scope.right++;

    //弹出笑脸
    $scope.picUrl = "__IMG__/smile.png";
    $scope.myCheck = 1;
    wait();

    //a数组去重为n
    var n = []; //一个新的临时数组
    //遍历当前数组
    for(var i = 0; i < a.length; i++){
        //如果当前数组的第i已经保存进了临时数组，那么跳过，
        //否则把当前项push到临时数组里面
        if (n.indexOf(a[i]) == -1) n.push(a[i]);
    }
    console.log(n.length);
    console.log(b);

    //判断是否都翻转了
    if (n.length == 16) {
        a = [];
        getwords();
        $(".flipper .back").removeClass("col");
        $(".flipper").addClass("reversal");
    }
};

    // 弹出 modal. size: lg大，sm小, 不传值为默认大小
    // 参考：https://angular-ui.github.io/bootstrap/
    var openModal = function (size) {
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'alertFatigue.html',
            controller: 'alertFatigue',
            size: size,
            resolve: {
                items: function () {
                    return $scope.items;
                }
            }
        });
    };

});
</script>