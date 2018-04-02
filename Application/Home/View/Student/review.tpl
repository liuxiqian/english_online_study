<extend name="Base:index" />
<block name="wrapper">
    <div class="row-fluid" ng-app="myApp" ng-controller="wordCtrl">
        <div class="row">
            <div class="col-md-12 col-xs-12">
            <form>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-{{widthLeft}}">
                            <div class="row"><!-- 难度 -->
                                <div class="col-md-12 star">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                            </div>
                            <div class="row"><!-- 单词图片 -->
                                <div class="col-md-1 col-md-offset-1">
                                    <h1><img src="__IMG__/smile.png" class="img-responsive"></h1>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h1><img src="__IMG__/1.png" class="img-responsive" style="display: inline"></h1>
                                        </div>
                                        <div class="col-md-4"><h1><button class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button></h1></div>
                                        <div class="col-md-4"><h1></h1></div>
                                    </div>
                                    <p>请选择你听到的词汇</p>
                                </div>
                                <div class="col-md-5">
                                    <div class="img-circle blue">
                                        <p class="circle">{{count}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6 col-md-offset-2">
                                    <div class="row"  ng-repeat="x in choice">
                                        <div class="col-md-1">
                                            <span ng-show="x.isRight && x.isClick" class="fa fa-check true"></span>
                                            <span ng-hide="!x.isRight && x.isClick" class="fa fa-check false"></span>
                                        </div>

                                        <div class="col-md-11">
                                            <div class="radio" >
                                                <label>
                                                    <input type="radio"  id="radio" ng-model="click" ng-change="isChange(click)" ng-value="x" />
                                                     {{x.title}}
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row hight"></div>
                            <div class="row">
                                <div class="col-md-5 col-md-offset-5">
                                    <button class="btn btn-lg btn-primary">下一个词汇  <span class="fa fa-chevron-right"></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-{{widthRight}}">
                            <div class="thumbnail">
                                <div class="row">
                                    <div class="col-md-1 align" ng-model="right" ng-click="toggle(right)">
                                            <button class="btn btn-link" ><i  class="fa fa-caret-{{right}}"></i></button>
                                    </div>
                                    <div class="col-md-10" ng-show="schedule">
                                        <div class="caption">
                                            <h4>今日进程</h4>
                                            <p>单词有效记忆时间（分钟）</p>
                                            <div class="progress">
                                              <div class="progress-bar active progress-striped" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width:65%;">
                                                20分钟
                                              </div>
                                            </div>
                                            <p>
                                                学习新词：0
                                            </p>
                                            <p>
                                                复习：0
                                            </p>
                                            <div class="part">
                                                <p>
                                                本次学习时间：00:00
                                            </p>
                                            </div>
                                            <h4 class="orange">总体进程</h4>
                                            <p>单词有效记忆时间（分钟）</p>
                                            <div class="progress">
                                              <div class="progress-bar active progress-striped" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width:65%;">
                                                20分钟
                                              </div>
                                            </div>
                                            <p>学习进度</p>
                                            <div class="progress">
                                              <div class="progress-bar active progress-striped" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width:0%;">

                                              </div>
                                            </div>
                                            <div class="part"></div>
                                            <h4 class="orange">上次进程</h4>
                                            <p>单词有效记忆时间（分钟）</p>
                                            <div class="progress">
                                              <div class="progress-bar active progress-striped" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width:65%;">
                                                20分钟
                                              </div>
                                            </div>
                                            <p>
                                                学习新词：0
                                            </p>
                                            <p>
                                                复习：0
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <include file="indexCss" />
    <include file="review.js" />
</block>
