<script id="studyHalfReview.html" type="text/ng-template">
    <div ng-controller="StudyHalfReviewCtrl">
        <div class="row">
            <!-- 难度 -->
            <div class="col-md-12 star" ng-bind-html="word.star | starFormat">
            </div>
        </div>
        <div class="row">
            <!-- 单词图片 -->
            <!-- <div class="col-md-1 col-md-offset-1">
                <h1><img src="__IMG__/smile.png" class="img-responsive"></h1>
            </div> -->
            <div class="col-md-5 col-md-offset-2">
                <div class="row">
                    <div ng-show="reviewShowWord" class="col-md-10">
                        <h1 ng-if="!isNewWord"><img src="__IMG__/1.png" class="img-responsive" style="display: inline"></h1>
                        <h1 ng-if="isNewWord" ng-bind="word.title"></h1>
                    </div>
                    <div class="col-md-2">
                        <h1><button ng-click="speak()" class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button></h1></div>
                </div>
                <p ng-if="!isNewWord">请选择你听到的词汇</p>
            </div>
            <div class="col-md-5">
                <div class="img-circle blue" ng-show="reviewCounts">
                    <p class="circle" ng-bind="count"></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                    <div ng-repeat="(key, question) in word.randomQuestionWords" class="row">
                        <div class="col-md-1">
                            <span id="question{{key}}-true" style="display:none" class="fa fa-check true"></span>
                            <span id="question{{key}}-false" style="display:none" class="glyphicon glyphicon-remove false"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radio" ng-click="judge({{question.id}},{{key}})" ng-disabled="disabled" /> {{question.translation}}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-1">
                           <span ng-click="addNewWord()" id="word{{key}}" style="display:none" class="glyphicon glyphicon-edit true"></span>
                        </div>
                    </div>
            </div>
        </div>
    <div class="row">
        <div ng-show='info' class="alert alert-success col-md-6 col-md-push-3" role="alert" ng-bind="info"></div>
        <div ng-show="nextButton" class="col-md-5 col-md-offset-5">
            <a ng-click="skip(word)" class="btn btn-primary">下一个词汇 <span class="fa fa-chevron-right"></span></a>
        </div>
    </div>
    </div>
</script>
