<div class="container" ng-controller="WordDetailCtrl">
    <div class="row box box-primary">
        <div class="col-md-12 box-body">
            <div class="row">
                <div class="col-md-12">
                    <h5>当前位置： {$breadCrumbTitle}&nbsp;>&nbsp;{{word.title}}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-1">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="button" class="btn btn-default btn-sm" ng-click="speak()">
                                <span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span>
                                <audio id="audio">对不起，您的浏览器不支持HTML5。读音无法播放。</audio>
                            </button>
                            <button ng-click="addNewWord()" uib-popover="{{info}}" popover-trigger="mouseenter" type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                            <button ng-click="relation()" type="button" class="btn btn-default btn-sm">
                                <span aria-hidden="true">查看关联单词</span>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" ng-click="open()">
                                <span aria-hidden="true">练一练</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row em14">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <h1 ng-bind="word.title"></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p>[<span ng-bind="word.ukPhonetic"></span>]</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p ng-bind="word.explain"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <p><label for="inputPassword3" class="col-md-2 control-label">例句：</label></p>
                            <div class="col-md-2">
                                <button ng-click="model(english,chinese)" type="button" class="btn btn-default btn-sm">
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
                    <div class="row">
                        <ul class="pager">
                            <eq name="ACTION_NAME" value="starWord">
                                <li class="col-md-6">
                                    <a ng-hide="isFirst" href="javascript:void(0);" ng-click="preWord()">上一个</a>
                                </li>
                                <li class="col-md-6">
                                    <a ng-hide="isLast" href="javascript:void(0);" ng-click="nextWord()">下一个</a>
                                </li>
                            <else />
                                <li class="col-md-12">
                                    <button uib-popover="快捷键→" popover-trigger="mouseenter" ng-click="skip(word)" type="button" class="btn btn-primary">下一个单词 &nbsp;<span class="fa fa-chevron-right"></span></button>
                                </li>
                            </eq>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="javascript:void(0)" ng-click="relationPicture = !relationPicture"><h4 ng-bind="word.title"></h4></a>
                    <include file="relationPicture" />
                </div>
            </div>
        </div>
    </div>
</div>
