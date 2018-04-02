<extend name="Base:index" />
<block name="body">
<body onselectstart="return false">
</block>
<block name="wrapper">
    <h4>{:$Course->getTitle()}</h4>
    <div ng-app="yunzhi" ng-controller="IndexCtrl" ng-init="init()">

        <div id="mydiv" class="loading"><img src="__IMG__/spiner.gif" class="ajax-loader"/></div>
        <div ui-view></div>

        <include file="studyHalf" />
        <include file="studyHalfIndex" />
        <include file="studyHalfReview" />
        <include file="studyHalfIdentify" />
        <script type="text/ng-template" id="studyWordDetail.html">
            <include file="studyWordDetail" />
        </script>
        <script type="text/ng-template" id="myModalContent.html">
            <include file="myModalContent" />
        </script>
        <include file="index.js" />
        <include file="Factory.js" />
        <include file="studyConfig.js" />
        <include file="studyWordDetail.js" />
        <include file="studyHalf.js" />
        <include file="studyHalfIndex.js" />
        <include file="studyHalfReview.js" />
        <include file="studyHalfIdentify.js" />
        <include file="filter.js" />
        <include file="index.css" />
        
        <!--弹出休息一会对画框-->
        <script type="text/ng-template" id="alertFatigue.html">
            <include file="alertFatigue" />  
        </script>
        <include file="alertFatigue.js" />
    </div>
</block>
