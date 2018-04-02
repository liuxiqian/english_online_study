<extend name="Base:index" />
<block name="wrapper">
    <include file="linkLook.css" />
    <include file="LinkLookHome.js" />

<div ng-app="myapp">
<div ng-controller="LinkLookHome">
    <div class="load" ng-show="myCheck"><img ng-src="{{picUrl}}" class="loader" /></div>
    <div style="background:url(__IMG__/bg.png) repeat-x;height:264px;">
    </div>
    <div class="container" style="margin-top:-180px;">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" id="main_main_header">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8" id="main_main">
                        <div class="row" >
                            <div class="col-md-12" style="background-image:url(__IMG__/select.png);background-size:100% 95%;">
                                <div class="row">
                                    <audio id="audio1" style="width:25%;display:none;" ng-show="1"  controls>Canvas not supported</audio>
                                    <div class="col-md-1 col-md-offset-5">
                                        <a><span ng-click="playAudio()" class="{{laba}}" style="margin-top: 18px;padding-left: 22px;"></span></a>
                                    </div>
                                    <div class="col-md-2 col-md-offset-1">
                                        <div class="progress" style="margin-top:15px;margin-left:-18px;width:86%;">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{time}}%">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div style="margin-top:11px;font-size:20px;color:#fff;">{{right}}</div>
                                    </div>
                                    <div class="col-md-1">
                                        <div style="margin-top:11px;margin-left:35px;font-size:20px;color:#fff;">{{error}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="game row" >
                            <div class="col-md-3" style="margin-top:-10px">
                                <div ng-repeat="word in results[0] track by $index" class="flip-container" ng-click="look(word)" ontouchstart="this.classList.toggle('hover');">
                                    <div class="flipper pic-{{word.num}} reversal">
                                        <div class="front">
                                            <!-- 前面内容 -->
                                        </div>
                                        <div class="back word text-center">
                                            <!-- 背面内容 -->
                                            {{word.name}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top:-10px">
                                <div ng-repeat="word in results[1] track by $index" class="flip-container" ng-click="look(word)">
                                    <div class="flipper pic-{{word.num}} reversal">
                                        <div class="front">
                                            <!-- 前面内容 -->
                                        </div>
                                        <div class="back word text-center">
                                            <!-- 背面内容 -->
                                            {{word.name}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top:-10px">
                                <div ng-repeat="word in results[2] track by $index" class="flip-container" ng-click="look(word)">
                                    <div class="flipper pic-{{word.num}} reversal">
                                        <div class="front">
                                            <!-- 前面内容 -->
                                        </div>
                                        <div class="back word text-center">
                                            <!-- 背面内容 -->
                                            {{word.name}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top:-10px">
                                <div ng-repeat="word in results[3] track by $index" class="flip-container" ng-click="look(word)">
                                    <div class="flipper pic-{{word.num}} reversal">
                                        <div class="front">
                                            <!-- 前面内容 -->
                                        </div>
                                        <div class="back word text-center">
                                            <!-- 背面内容 -->
                                            {{word.name}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--弹出游戏结束对画框-->
<script type="text/ng-template" id="alertFatigue.html">
    <include file="alertFatigue" />  
</script>
<include file="alertFatigue.js" />
</div>
</block>
</extend>