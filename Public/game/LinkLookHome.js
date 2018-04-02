
var myapp = angular.module("myapp", ['ngAnimate']);
myapp.controller('LinkLookHome', function($scope, $interval, $timeout, $http){
    /**
     * 1.http获取8随机单词
     * 2.加上释义混合成16
     * 3.前台循环输出
     * 4.点击判断是否相同
     */
    // var words = [
    //     {id:1,name:"hello"},
    //     {id:2,name:"hi"},
    //     {id:3,name:"what"},
    //     {id:4,name:"where"},
    //     {id:5,name:"no"},
    //     {id:6,name:"yse"},
    //     {id:7,name:"one"},
    //     {id:8,name:"go"},
    //     {id:8,name:"去"},
    //     {id:6,name:"是"},
    //     {id:5,name:"否"},
    //     {id:2,name:"嗨"},
    //     {id:1,name:"你好"},
    //     {id:3,name:"什么"},
    //     {id:4,name:"哪"},
    //     {id:7,name:"一"},
    // ];
    var words = [];

    var getwords = function () {
        $http.get('http://127.0.0.1/english_online_study/Public/index.php/Api/getLinkLookWordsAjax',{params:{count:'8'}})
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
$scope.time  = 100;//倒计时100秒
var a = [];//已经反转的
var b = [];//临时点击的

//倒计时
$interval(function() {
    if ($scope.time > 0) {
        $scope.time--;
    }
    if ($scope.time == 0) {
        //TODO:触发游戏结束的操作
    }
}, 1000);

//定义笑脸哭脸的时间
var wait = function () {
    $timeout(function(){
        $scope.myCheck = 0;
    }, 500);
}

//游戏点击的操作
$scope.look = function (index, value) {
    //判断临时数组b是否有值
    //没有，把当前的点击的push进去
    if (b.length == 0) {
        $(".pic-"+index+" .back").addClass("col");
        value.index = index;
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
        $scope.picUrl = "./img/cry.png";
        $scope.myCheck = 1;
        wait();

        return;
    }

    //相等，removeClass,清空b,push进a
    $(".pic-"+index).removeClass("reversal");
    $(".pic-"+b[0].index).removeClass("reversal");
    a.push(b[0]);
    a.push(value);
    b = [];
    $scope.right++;

    //弹出笑脸
    $scope.picUrl = "./img/smile.png";
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
        //TODO:触发$HTTP
        a = [];
        getwords();
        $(".flipper .back").removeClass("col");
        $(".flipper").addClass("reversal");
    }
};
});