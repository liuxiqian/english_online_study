<extend name="Base:index" />
<block name="wrapper">
    <div ng-app="yunzhi" ng-controller="starWordController">
        <!--单词发音-->
        <include file='Factory.speak.js' />
    
        <!--添加生词-->
        <include file='Factory.addNewWord.js' />

        <!--单词详情-->
        <include file="studyWordDetail" />
        <include file='starWord.js' />
        
        <!--单词详情JS-->
        <include file='studyWordDetail.js' />
        
        <!--练一练模板-->
        <script type="text/ng-template" id="myModalContent.html">
            <include file="myModalContent" />
        </script>
    </div>
</block>