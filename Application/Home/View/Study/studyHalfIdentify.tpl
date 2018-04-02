<script id="studyHalfIdentify.html" type="text/ng-template">
    <div ng-controller="StudyHalfIdentifyCtrl">
        <div class="row">
            <!-- 难度 -->
            <div class="col-md-12 star" ng-bind-html="word.star | starFormat">
            </div>
        </div>
        <div class="row">
            <!-- 单词图片 -->
            <div class="col-md-5 col-md-offset-2">
                <div class="row">
                    <div class="col-md-8">
                        <div ng-show="identifyShowWord">
                            <h1 ng-bind="word.title"></h1></div>
                    </div>
                    <!-- <div class="col-md-2">
                        <h1><button ng-show="button" class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button></h1>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h1><button ng-click="speak()" class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button></h1>
                    </div>
                </div>
                <div class="row" ng-show="identifySymbol">
                    <div class="col-md-10">
                        <h4 class="gloomy">[<span ng-bind="word.ukPhonetic"></span>]</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-5" ng-show="identifyPicture">
                <img ng-src="{{word.imageUrl}}" class="img-responsive">
            </div>
        </div>
        <div class="row hight">
            <div class="col-md-10 col-md-offset-2">
                <p ng-bind="word.explain"></p>
                <div ng-show="identifyExplains">
                    <p ng-repeat="explain in word.explains" ng-bind="explain.value"></p>
                </div>
                <div class="row">
                    <div class="col-md-1"><b>例句</b></div>
                    <div class="col-md-11">
                        <p ng-bind="word.example"></p>
                        <p ng-show="identifyChinese" ng-bind="word.exampleTranslate"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <a uib-popover="快捷键←" popover-trigger="mouseenter" class="btn btn-large btn-success" ng-click="jumpp(word)"><span class="fa fa-check"></span>  认对</a>
                <a uib-popover="快捷键→" popover-trigger="mouseenter" class="btn btn-large btn-danger" ng-href="#/studyWordDetail/1"><span class="fa fa-times"></span>  认错</a>
            </div>
        </div>
        <!-- 满意度 -->
    </div>
</script>
