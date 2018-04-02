<extend name="Base:index" />
<block name="wrapper">
    <div class="row-fluid" ng-app="myApp" ng-controller="wordCtrl">
        <div class="row">
            <div class="col-md-12 col-xs-12">
            {{word}}
            <form>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked="checked" ng-click="wordCheck()"> 词汇
                                </label>
                                <label>
                                    <input type="checkbox" checked="checked"  ng-click="USCheck()"> 美式读音
                                </label>
                                <label>
                                    <input type="checkbox" checked="checked"  ng-click="UKCheck()"> 英式读音
                                </label>
                                <label>
                                    <input type="checkbox" checked="checked" ng-click="syllableCheck()"> 音节
                                </label>
                                <label>
                                    <input type="checkbox" checked="checked" ng-click="symbolCheck()"> 音标
                                </label>
                                <label>
                                    <input type="checkbox" checked="checked" ng-click="countsCheck()"> 计时器
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-{{widthLeft}}">
                            <div class="row"><!-- 难度 -->
                                <div class="col-md-12 star" ng-bind-html="word.star | starFormat">
                                </div>
                            </div>
                            <div class="row"><!-- 单词图片 -->
                                <div class="col-md-5 col-md-offset-2">
                                    <div class="row">
                                        <div class="col-md-6" ng-show="showWord"><h1 ng-bind="word.title"></h1></div>
                                        <div class="col-md-6" ng-show="syllable"><h1 ng-bind="word.syllable"></h1></div>
                                    </div>
                                    <div class="row">
                                        <div ng-show="UK" class="col-md-6"><span class="read">英音</span><button ng-click="speak('uk')" class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button></div>
                                        <div ng-show="US" class="col-md-6"><span class="read">美音</span><button ng-click="speak('us')" class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button></div>
                                    </div>
                                    <!-- <div class="rol"></div> -->
                                    <div class="row">
                                        <h4 ng-show="symbol" class="col-md-6">[<span ng-bind="word.ukPhonetic"></span>]</h4>
                                        <h4 ng-show="symbol" class="col-md-6">[<span ng-bind="word.usPhonetic"></span>]</h4>
                                    </div>
                                    <audio id="audio">您的浏览器不支持HTML5，单词读音无法正常播放</audio>
                                </div>
                                <div class="col-md-5">
                                    <div class="img-circle blue" ng-show="counts">
                                        <p class="circle">{{count}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row hight"></div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <a class="btn btn-large btn-success" href="{:U('identify')}"><span class="fa fa-smile-o"></span>  认识</a>
                                    <a class="btn btn-large btn-danger" href="{:U('Index/wordDetail')}"><i class="fa fa-frown-o"></i>  不认识</a>
                                    <a class="btn btn-large btn-warning" href="{:U('identify')}"><i class="fa fa-meh-o"></i>  拿不准</a>
                                </div>
                            </div><!-- 满意度 -->
                        </div>
                        <div class="col-md-{{widthRight}}">
                            <div class="thumbnail">
                                <div class="row">
                                    <div class="col-md-1 align">
                                            <button class="btn btn-link" ng-model="right" ng-click="toggle(right)"><i  class="fa fa-caret-{{right}}"></i></button>
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
                                            <h4>总体进程</h4>
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
                                            <h4>上次进程</h4>
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
    <include file="index.js" />
</block>
