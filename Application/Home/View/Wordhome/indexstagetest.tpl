<extend name="Base:index" />
<block name="wrapper">
<div class="container-fluid" ng-app="Home" ng-controller="index">
    <div class="row-fluid">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-2">
                        <a href="{:U('Index/review1')}" class="btn btn-success btn-lg" role="button">词汇记忆
                            <span class="glyphicon glyphicon-play-circle"></span>
                        </a>
                        
                    </div>
                    <div class="col-md-2">
                        
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                         新学110词，复习44词，共354词
                        </div>
                        <div class="row progress">
                            <div class="progress-bar progress-bar-warning" style="width: 10%">
                            <span class="sr-only">10% Complete (success)</span>
                            </div>
                            <div class="progress-bar progress-bar-primary progress-bar-striped" style="width: 20%">
                                <span class="sr-only">20% Complete (warning)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <h1 style="color: red; margin-top: 0px;">93</h1>
                    </div>
                </div>
            </div>
                <div class="row">
                        <div ng-show="relationPicture" class="col-md-6 jumbotron" style="padding-bottom: 144px; padding-top: 125px;">
                            <h1 uib-popover="v.牢记,记住;" popover-title="[rɪˈmembə(r)]" popover-trigger="mouseenter" ng-click="example()">remember</h1>
                            <p ng-show="exampleWord">同义词</p>
                            <p ng-show="exampleWord">反义词</p>
                        </div>
                        <div class="col-md-5">
                            <div class="list-group">
                                <a href="#" class="list-group-item active">
                                    难词
                                </a>
                                <a href="{:U('Index/wordDetail')}" class="list-group-item text-center">remember</a>
                                <a href="#" class="list-group-item text-center">Morbi</a>
                                <a href="#" class="list-group-item text-center">Porta</a>
                                <a href="#" class="list-group-item text-center">Vestibulum</a>
                                <a href="#" class="list-group-item text-center">Dapibus</a>
                                <a href="#" class="list-group-item text-center">Morbi</a>
                                <a href="#" class="list-group-item text-center">Porta</a>
                                <a href="#" class="list-group-item text-center">Vestibulum</a>
                                <a href="#" class="list-group-item text-center">Vestibulum</a>
                                <a href="#" class="list-group-item text-center">Vestibulum</a>
                                <a href="#" class="list-group-item text-center">Dapibus</a>
                            </div>
                        </div>
                </div>
            
        </div>
    </div>
</div>
<include file="index.js"/>
</block>