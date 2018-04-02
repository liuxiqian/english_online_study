<extend name="Base:index" />
<block name="wrapper">
<div class="container" ng-app="myApp" ng-controller="WordTest">
    <php>$isAllowed = $Test->getIsAllow($Student);</php>
    <eq name="isAllowed" value="0">
    <div class="row">
        <div class="col-md-push-2 col-md-8">
            <h4 class="alert alert-warning text-center" role="alert">:( 您今日新学单词{:$Test->getTodayNewStudyCount()}个，距离50个还差{:(50-$Test->getTodayNewStudyCount())}个，还不能激活自我测试哟</h4>
        </div>
    </div>
    </eq>
    <div class="row">
        <div class="col-md-offset-2">
            <div class="row">
                <div class="col-md-2">
                    <h3>效果检测</h3>
                </div>
                <div class="col-md-10">
                    <p>本卷用于检测你每天的学习效果。<br /></p>
                    <p>共50道单选题，给每个单词选出最合适的中文释义。限时3分钟，每道题仅有3-4秒的作答时间。<br /></p>
                    <p>注意：一天一次效果最佳。系统不记录考试成绩。<br /></p>
                    <eq name="isAllowed" value="1"><a href="{:U('Test/index?type=explain')}" class="btn btn-primary btn-md testbutton">开始检测</a></eq>
                </div>            
            </div>
            <hr >
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-2">
            <div class="row">
                <div class="col-md-2">
                    <h3>听写测试</h3>
                </div>
                <div class="col-md-10">
                    <p>本卷用于测试你的听写能力。<br /></p>
                    <p>共50道听写题，先点击题号后边的小喇叭听声音，然后再输入框里输入单词。限时15分钟，每题仅有18秒的作答时间。<br /></p>
                    <p>注意：需要一定的键盘输入技能，一天一次效果最佳。系统不记录考试成绩。<br /></p>
                    <eq name="isAllowed" value="1"><a href="{:U('Test/index?type=write')}" class="btn btn-primary btn-md testbutton">开始测试</a></eq>
                </div>
            </div>
            <hr >
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-2">
            <div class="row">
                <div class="col-md-2">
                    <h3>自我评估</h3>
                </div>
                <div class="col-md-10">
                    <p>本卷用于评估你的综合水平。<br /></p>
                    <p>共50道题，含单选、听辨、听写3种形式。限时10分钟，每题仅有12秒的作答时间。<br /></p>
                    <p>注意：本卷可随时进行，但频度以每周一次最佳。系统不记录考试成绩。<br /></p>
                    <eq name="isAllowed" value="1"><a href="{:U('Test/index?type=all')}" class="btn btn-primary btn-md testbutton">开始评估</a></eq>
                </div>
            </div>
            <hr >
        </div>
    </div>
  
</div>
<include file="test.css"/>
<include file="test.js"/>
</block>