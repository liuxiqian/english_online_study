<extend name="Base:index" />
<block name="wrapper">
    <div class="container-fluid" ng-app="Home" ng-controller="index">
        <div class="row-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <h3>{:$Course->getTitle()}</h3>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-{$width}">
                            <eq name="isStudyShow" value="1">
                                <a href="{:U('Study/index?courseId=' . I('get.id'))}" class="btn btn-success btn-lg" role="button">词汇记忆
                                <span class="glyphicon glyphicon-play-circle"></span></a>
                            </eq>
                            <eq name="isTestShow" value="1">
                                <php>$Test = $StudentCourse->getCurrentTest();</php>
                                <eq name="Test:getType()" value="0">
                                    <button ng-click="openModal('{:U('Test/index?id=' . $Test->getId())}')" type="button" class="btn btn-warning btn-lg">{:$Test->getTitle()}&nbsp;<span class="glyphicon glyphicon-play-circle"></span></button>&nbsp;
                                <else />
                                    <a href="{:U('Test/index?id=' . $Test->getId())}" class="btn btn-warning btn-lg" role="button">{:$Test->getTitle()}
                                    &nbsp;<span class="glyphicon glyphicon-play-circle"></span></a>
                                    &nbsp;
                                </eq>
                            </eq>
                            <eq name="isReviewShow" value="1">
                                <a href="{:U('Study/reviewWord?courseId=' . $Course->getId())}" class="btn btn-primary btn-lg">复习&nbsp;<i class="glyphicon glyphicon-refresh"></i></a>
                            </eq>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                新学<span ng-bind="newCount"></span>词，复习<span ng-bind="oldCount"></span>词，共<span ng-bind="totalCount"></span>词。
                            </div>
                            <div class="row progress">
                                <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: {{getProccess(0, 10)}}%">
                                </div>
                                <div class="progress-bar progress-bar-primary progress-bar-striped" style="width: {{getProccess(10, 60)}}%">
                                </div>
                                <div class="progress-bar progress-bar-success progress-bar-striped" style="width: {{getProccess(60, 100)}}%">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h1 style="color: red; margin-top: 0px;">{:$Course->getLastScore($Student)}</h1>
                        </div>
                    </div>
                </div>
               
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>游戏闯关</h3>
                            <eq name="StudentCourse:getIsDone()" value=""><p>游戏闯关尚未激活。激活条件：本课程学习完毕。</p></eq>
                            <hr />
                            <neq name="StudentCourse:getIsDone()" value="">
                            <div class="row">
                                <div class="col-md-6 game">
                                    <a href="{:U('Game/linkLook?courseId=' . I('get.id'))}"><img src="__IMG__/link.png" alt="连连看" /></a>
                                </div>
                                <div class="col-md-6 game">
                                    <a href="{:U('Game/SpellIndex?courseId=' . I('get.id'))}"><img src="__IMG__/spell.png" alt="单词拼写" /></a>
                                </div>
                            </div>
                            </neq>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <include file="index.js" />
    <include file="right.css" />
</block>
