<extend name="Base:index" />
<block name="wrapper">
<div class="container-fluid">
    <div class="row-fluid">
        <div class="row">
            <div class="panel panel-default text-center">
            <?php if ($Test->getType() != 0) : ?>
                
                <eq name="Test:getType()" value="1">
                    <h2 class="text-center test">
                        你已经学完了本阶段词汇
                    </h2>
                    <h2>你可以复习本组内词汇，也可以进行组测试。组测试检查你对本组词汇的掌握情况。组测试的正确率要求是：80%。通过组测试后，你可以继续学习。</h2>
                <else />
                    <h2 class="text-center test">
                        你已经学完了本阶段词汇
                    </h2>
                    <h2>你可以复习本阶段内词汇，也可以进行阶段测试。阶段测试检查你对本阶段词汇的掌握情况。阶段测试的正确率要求是：80%。通过阶段测试后，你可以继续学习。</h2>
                </eq>
                
                <a href="{:U('Study/reviewWord?courseId=' . I('get.courseId'))}"><button type="button" class="btn btn-success btn-lg testbutton"><i class="glyphicon glyphicon-refresh"></i>&nbsp;复习本课程</button></a>&nbsp;&nbsp;&nbsp;
                <a href="{:U('Test/index?id=' . $Test->getId())}"><button type="button" class="btn btn-primary btn-lg testbutton"><i class="glyphicon glyphicon-play-circle"></i>&nbsp;{:$Test->getTitle()}</button></a>
            <?php else : ?>
                <h2 class="text-center test">
                :( 闪电侠，休息一会吧。
                </h2>
                <a href="{:U('Study/index?courseId=' . I('get.courseId'))}"><button type="button" class="btn btn-success btn-lg testbutton">继续学习&nbsp;<span class="glyphicon glyphicon-play-circle"></span></button></a>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<include file="beforestudytest.css"/>
</block>
