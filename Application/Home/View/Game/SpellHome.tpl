<extend name="Base:index" />
<block name="wrapper">
    <div class="row" ng-app="App" ng-controller="Spell">
        <div class="col-md-8 col-md-push-2">
            <div id="game">
                <audio id="audio" class="audio"></audio>
                <div class="header">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{remainTime}}" aria-valuemin="0" aria-valuemax="{{totalTime}}" style="width:{{remainTime * 100/totalTime}}%;">
                        </div>
                    </div>
                    <div class="rightCount">{{rightCount}}</div>
                    <div class="wrongCount">{{wrongCount}}</div>
                </div>
                <div class="config checkbox">
                        <label>
                           <input type="checkbox" ng-model="isShowAudio" />&nbsp;读音
                        </label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label>
                            <input type="checkbox" ng-model="isShowExplain" />&nbsp;释义
                        </label>
                </div>
                <div class="spell">
                    <a href="javascript:void(0)" ng-click="speak()"></a>
                    <input ng-model="spell" type="text" press-enter="pressEnter()" placeholder="{{placeholder}}" />
                    <a href="javascript:void(0)" ng-click="pressEnter()"></a>
                </div>
                <div ng-show="isShowExplain" class="explain">
                    {{word.explain}}
                    <ul>
                        <li ng-repeat="(key, _explain) in word.explains" ng-show="key < 3">
                            {{_explain.value}}
                        </li>  
                    </ul>
                </div>
                <div class="picInfo slide-down" ng-show="showPic">
                    <img  ng-src="{{picUrl}}" />
                </div>
            </div>
        </div>
    </div>
    <include file="SpellHome.js" />
    <include file="SpellHome.css" />
</block>
</extend>
