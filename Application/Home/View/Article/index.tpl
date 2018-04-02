<extend name="Base:index" />
<block name="wrapper">
    <div class="col-md-12 col-sm-12" ng-app="myApp" ng-controller="MyArticle">
        <h1 class="col-md-12 text-center">{$Article->getTitle()}&nbsp;&nbsp;
            <button type="button" class="btn btn-md btn-info" id="playbutton" ng-click="togglePlay()"><i class="glyphicon glyphicon-headphones"></i>&nbsp;Play</button>
        </h1>
         <audio id="audio" ng-show="showPlayer" style="width:25%;" controls>请使用支持html5的浏览器</audio>
        
        <div class="row">
            <div class="col-md-12">
                {$Article->getEnglishText() | htmlspecialchars_decode}
            </div>
        </div>
        <div class="row">
            <button type="button" class="btn btn-info col-md-1" ng-click="allArticle()">译文/大意</button>
            <div class="col-md-12" ng-hide="myCheck">
                {$Article->getChineseText() | htmlspecialchars_decode}
            </div>
        </div>
    </div>
    <include file="index.css" />
    <include file="index.js" />
    <include file="Base/js" />
</block>
