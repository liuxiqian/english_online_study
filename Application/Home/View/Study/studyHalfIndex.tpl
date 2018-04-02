<script id="studyHalfIndex.html" type="text/ng-template">
    <div ng-controller="StudyHalfIndexCtrl">
        <div class="row">
            <!-- 难度 -->
            <div class="col-md-12 star" ng-bind-html="word.star | starFormat">
            </div>
        </div>
        <div class="row">
            <!-- 单词图片 -->
            <div class="col-md-5 col-md-offset-2">
                <div class="row">
                    <div class="col-md-12">
                        <div ng-show="indexShowWord">
                            <h1 ng-bind="word.title"></h1>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div ng-show="syllable">
                            <h1 ng-bind="word.syllable"></h1>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div ng-show="indexUK"><span class="read">英音</span>
                            <button ng-click="speak('uk')" class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div ng-show="indexUS"><span class="read">美音</span>
                            <button ng-click="speak('us')" class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button>
                        </div>
                    </div>
                </div>
                <!-- <div class="rol"></div> -->
                <div class="row">
                    <div class="col-md-6">
                        <h4 ng-show="UK">[<span ng-bind="word.ukPhonetic"></span>]</h4>
                    </div>
                    <div class="col-md-6">
                        <h4 ng-show="US">[<span ng-bind="word.usPhonetic"></span>]</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="img-circle blue" ng-show="indexCounts">
                    <p class="circle" ng-bind="count"></p>
                </div>
            </div>
        </div>
        <div class="row hight"></div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <a  uib-popover="快捷键←" popover-trigger="mouseenter" class="btn btn-large btn-success"  ng-href="#/half/identify/0"><span class="fa fa-smile-o"></span>  认识</a>
                <a uib-popover="快捷键↓" popover-trigger="mouseenter" class="btn btn-large btn-danger" ng-href="#/studyWordDetail/1"><i class="fa fa-frown-o"></i>  不认识</a>
                <a uib-popover="快捷键→" popover-trigger="mouseenter" class="btn btn-large btn-warning" ng-href="#/half/identify/1"><i class="fa fa-meh-o"></i>  拿不准</a>
            </div>
        </div>
        <!-- 满意度 -->
    </div>
</script>
