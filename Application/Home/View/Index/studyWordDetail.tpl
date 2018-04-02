<extend name="Base:index" />
<block name="wrapper">
    <div ng-app="myapp" class="container" ng-controller="WordDetailCtrl">
        <div class="row box box-primary">
            <div class="col-md-12 box-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-1">
                        <div class="row">
                            <h5>当前位置：难词>{{word.title}}</h5></div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="button" class="btn btn-default btn-sm" ng-click="speak('uk')">
                                    <span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span>
                                    <audio id="audio">对不起，您的浏览器不支持HTML5。读音无法播放。</audio>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                <button ng-click="relation()" type="button" class="btn btn-default btn-sm">
                                    <span aria-hidden="true">查看关系图</span>
                                </button>
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" ng-click="open()">
                                    <span aria-hidden="true">练一练</span>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h1 ng-bind="word.title"></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h4>[<span ng-bind="word.ukPhonetic"></span>]</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h3 ng-bind="word.explain"></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <h4><label for="inputPassword3" class="col-md-2 control-label">例句：</label></h4>
                                <div class="col-md-2">
                                    <button ng-model="english" ng-model="chinese" ng-click="model(english,chinese)" type="button" class="btn btn-default btn-sm">
                                        <span aria-hidden="true">释义</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-show="english">
                            <label class="col-md-12 control-label" ng-bind="word.example"></label>
                        </div>
                        <div class="row" ng-show="chinese">
                            <label class="col-md-12 control-label" ng-bind="word.exampleTranslate"></label>
                        </div>
                    </div>
                    <div ng-show="relationPicture" class="col-md-4 jumbotron" style="padding-bottom: 144px; padding-top: 125px;">
                        <h1 uib-popover="v.牢记,记住;" popover-title="[rɪˈmembə(r)]" popover-trigger="mouseenter" ng-click="example()">{{word.title}}</h1>
                        <p ng-show="exampleWord">同义词</p>
                        <p ng-show="exampleWord">反义词</p>
                    </div>
                </div>
                <div class="row">
                    <ul class="pager">
                        <div class="col-md-2 col-md-offset-1">
                            <li><a ng-click="lastword({:$word->getId()})" href="{:U('Index/studyWordDetail?wordid='.$word->getId())}">上一页</a></li>
                        </div>
                        <div class="col-md-2 col-md-offset-2">
                            <li><a ng-click="nextword" href="#">下一页</a></li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <h3 class="modal-title">练一练</h3>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="ok()">确定</button>
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>
    <include file="studyWordDetail.js" />
</block>
