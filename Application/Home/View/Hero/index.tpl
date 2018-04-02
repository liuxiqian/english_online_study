<extend name="Base:index" />
<block name="wrapper">
    <!--由于要先触发在JS中的获取分页数据，近而获取数据分页信息，所以将JS置前-->
    <include file="index.js" />
    <div ng-app="Hero" ng-controller="myHero">
        <uib-tabset active="activeJustified" justified="true">
            <uib-tab index="0" heading="我的学习榜样" ng-click="setTab('myHero')">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr class="info">
                                        <th>姓名</th>
                                        <th>被指定次数</th>
                                        <th>词汇量</th>
                                        <th>学习速度</th>
                                        <th>前测成绩</th>
                                        <th>后测成绩</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <foreach name="Hero:getHeroStudents()" item="Student">
                                        <tr>
                                            <td><img src="{:$Student->getAttachment()->getUrl()}" width="28" height="28">{:$Student->getName()}</td>
                                            <td>{:$Student->getBeHeroNumber()}</td>
                                            <td>{:$Student->getTotalStudyCount()}</td>
                                            <td>{:$Student->getStudySpeed()}</td>
                                            <td>{:$Student->getMinGrade()}</td>
                                            <td>{:$Student->getMaxGrade()}</td>
                                        </tr>
                                    </foreach>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </uib-tab>
            <uib-tab index="1" heading="我是学习榜样" ng-click="setTab('meHero')">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <?php if (count($Hero->getBeHeroStudents()) === 0) : php?> <p>还没有人选择我做为学习榜样！</p>
                        <?php endif;  php?>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr class="info">
                                        <th>姓名</th>
                                        <th>指定次数</th>
                                        <th>词汇量</th>
                                        <th>学习速度</th>
                                        <th>前测成绩</th>
                                        <th>后测成绩</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <foreach name="Hero:getBeHeroStudents()" item="Student">
                                        <tr>
                                            <td><img src="{:$Student->getAttachment()->getUrl()}" width="28" height="28">{:$Student->getName()}</td>
                                            <td>{:$Student->getBeHeroNumber()}</td>
                                            <td>{:$Student->getTotalStudyCount()}</td>
                                            <td>{:$Student->getStudySpeed()}</td>
                                            <td>{:$Student->getMinGrade()}</td>
                                            <td>{:$Student->getMaxGrade()}</td>
                                        </tr>
                                    </foreach>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </uib-tab>
            <uib-tab index="2" heading="修改学习榜样" ng-click="setTab('modifyHero')">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <form action="{:U('index', I('get.'))}" method="get">
                                <div>
                                    <input type="radio" id="hero-self" ng-model="student.heroIsSelf" ng-change="toggle(1)" name="hero" value="1" /><label for="hero-self">我的学习榜样是我自己</label>&nbsp;&nbsp;
                                    <input type="radio" ng-model="student.heroIsSelf" ng-change="toggle(0)" id="hero-other" name="hero" value="0" /><label for="hero-other">不，我要指定同学作为我的学习榜样</label>
                                </div>
                                
                                <div ng-show="!showSelf">
                                    <div class="row">
                                        <div class="col-md-3 col-md-offset-9">
                                            <div class="input-group custom-search-form">
                                                <input class="form-control" name="keywords" placeholder="姓名..." type="text" value="{:I('get.keywords')}" />
                                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr class="info">
                                                    <th>姓名</th>
                                                    <th>被指定次数</th>
                                                    <th>词汇量</th>
                                                    <th>学习速度</th>
                                                    <th>前测成绩</th>
                                                    <th>后测成绩</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="hero in heros">
                                                    <td><input ng-model="hero.isHero" id="name_{{hero.id}}" type="checkbox" name="hero_id" value="1" ng-change="toggleHero(hero.id)" /><label for="name_{{hero.id}}">&nbsp;&nbsp;<img ng-src="{{hero.imgUrl}}" style="max-height: 30px;"/>&nbsp;{{hero.name}}</label></td>
                                                    <td ng-bind="hero.beHeroNumber"></td>
                                                    <td ng-bind="hero.totalStudyCount"></td>
                                                    <td ng-bind="hero.studySpeed"></td>
                                                    <td ng-bind="hero.minGrade"></td>
                                                    <td ng-bind="hero.maxGrade"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <nav>
                                            <Yunzhi:page totalcount="Hero:getTotalCount()" />
                                        </nav>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </uib-tab>
        </uib-tabset>
        
    </div>
</block>
