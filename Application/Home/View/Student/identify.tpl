<extend name="Base:index" />
<block name="wrapper">
    <div class="row-fluid" ng-app="myApp" ng-controller="wordCtrl">
        <div class="row">
            <div class="col-md-12 col-xs-12">
            <form>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  ng-click="wordCheck()"> 词汇
                                </label>
                                <label>
                                    <input type="checkbox"  ng-click="buttonCheck()"> 读音
                                </label>
                                <label>
                                    <input type="checkbox" ng-click="symbolCheck()"> 音标
                                </label>
                                <label>
                                    <input type="checkbox" ng-click="pictureCheck()"> 图片
                                </label>
                            </div>
                        </div>
                    </div>
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
                                <div class="col-md-5 col-md-offset-2">
                                    <div class="row">
                                        <div class="col-md-4"><div ng-show="word"><h1>peel</h1></div></div>
                                        <div class="col-md-4"><h1><button ng-show="button" class="btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-volume-up"></span></button></h1></div>
                                        <div class="col-md-4"><h1></h1></div>
                                    </div>
                                    <div class="rol">
                                        <h4 ng-show="symbol">[pi:l]</h4>
                                    </div>
                                </div>
                                <div class="col-md-5" ng-show="picture">
                                    <img src="__IMG__/peel.jpg" class="img-responsive">
                                </div>
                            </div>
                            <div class="row hight">
                                <div class="col-md-10 col-md-offset-2">
                                    <p>vt:剥皮; 覆盖层脱落，剥落;</p>
                                    <p>vi:剥落; 脱落; 揭掉; 表面起皮</p>
                                    <div class="row">
                                        <div class="col-md-2">例句</div>
                                        <div class="col-md-10">
                                            <p>The pears and the peaches peel easily.</p>
                                            <p>梨子和桃子很容易剥皮。</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <a class="btn btn-large btn-success" href="{:U('index')}"><span class="fa fa-check"></span>  认对</a>
                                    <a class="btn btn-large btn-danger" href="{:U('Index/wordDetail')}"><span class="fa fa-times"></span>  认错</a>
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
    <include file="identify.js" />
</block>
