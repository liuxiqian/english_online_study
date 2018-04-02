<script>
var app = angular.module("Hero", ['ui.bootstrap']);
app.factory('sessionService', function() {
    return {
        set: function(key, value) {
        return sessionStorage.setItem(key, value);
        },

    get: function(key) {
        return sessionStorage.getItem(key);
        },

    destroy: function(key) {
        return sessionStorage.removeItem(key);
        }
    }
});

app.controller("myHero",function($scope, sessionService, $http){
    //修改榜样的显示隐藏
    $scope.student = {heroIsSelf:{:json_encode($Hero->getHeroIsSelf())}};

    // 获取所有榜样信息(下一步，进行分页，亲)
    $scope.heros = [<?php foreach($Hero->getHeros() as $hero) :?>
        {
            id:{:$hero->getId()},
            name:'{:$hero->getName()}',
            isHero:{:$Hero->getIsHeroJson($hero)},
            imgUrl:'{:$hero->getAttachment()->getUrl()}',
            beHeroNumber: '{:$hero->getBeHeroNumber()}',
            totalStudyCount: '{:$hero->getTotalStudyCount()}',
            studySpeed: '{:$hero->getStudySpeed()}',
            minGrade: '{:$hero->getMinGrade()}',
            maxGrade: '{:$hero->getMaxGrade()}',
        },
        <?php endforeach; ?>
        ];


    // 设置或取消榜样
    $scope.toggleHero = function(id)
    {
        $http.get('{:U("toggleHeroAjax")}', {params:{id:id}})
            .success(function(response){
                if (response.status == 'ERROR')
                {
                     alert(response.data);
                }
                else
                {

                }
            })
            .error(function(response){
                alert("系统或网络错误");
                console.log(response);
        });
    }

    // 设置学习榜样是否为自己
    $scope.toggle = function(type)
    {
        $scope.showSelf = ($scope.student.heroIsSelf == "1") ? true : false;
        $http.get('{:U("setHeroIsSelfAjax")}', {params:{type:type}})
            .success(function(response){
                console.log(response);
                if (response.status == 'ERROR')
                {
                     alert(response.data);
                }
            })
            .error(function(response){
                alert("系统或网络错误");
                console.log(response);
        });
    }
    $scope.toggle();

    $scope.setTab = function(active) {
        sessionService.set('active',active); 
        if(active === "myHero"){            //判断当前应该是哪个页面被选中了
            var tabState = JSON.stringify({
                activeJustified:0
            });
            sessionService.set('tabActive',tabState);  //将tabState存储到tabActive
            var tabActive = JSON.parse(sessionService.get('tabActive'));
            $scope.activeJustified = tabActive.activeJustified;//将判断结果（需要选中的页）赋给$scope.activeJustified供html代码使用
        }else if (active === "meHero") {    //判断当前应该是哪个页面被选中了
            var tabState = JSON.stringify({
                activeJustified:1
            });
            sessionService.set('tabActive',tabState); //将tabState存储到tabActive
            var tabActive = JSON.parse(sessionService.get('tabActive'));
            $scope.activeJustified = tabActive.activeJustified;//将判断结果（需要选中的页）赋给$scope.activeJustified供html代码使用
        }
        else if (active === "modifyHero") { //判断当前应该是哪个页面被选中了
            var tabState = JSON.stringify({
                activeJustified:2
            });
            sessionService.set('tabActive',tabState);//将tabState存储到tabActive
            var tabActive = JSON.parse(sessionService.get('tabActive'));
            $scope.activeJustified = tabActive.activeJustified;//将判断结果（需要选中的页）赋给$scope.activeJustified供html代码使用
        }else{
            var tabActive = JSON.parse(sessionService.get('tabActive'));
            $scope.activeJustified = tabActive.activeJustified;//将判断结果（需要选中的页）赋给$scope.activeJustified供html代码使用
        }
    }

    var active = sessionService.get('active');
    if (active === null)
    {
        active = 'myHero';
    }
    $scope.setTab(active);
});

</script>

