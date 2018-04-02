<extend name="Base:index" />
<block name="wrapper">
<div class="container-fluid">
    <div class="row-fluid">
        <div class="row">
            <div class="panel panel-default text-center">
                <h2 class="text-center test">
                    您已经学完了本课程词汇。您可以复习本课程内词汇，也可以进行其他课程学习。
                </h2>
                <a href="{:U('study/reviewWord?courseId=' . I('get.courseId'))}"><button type="button" class="btn btn-success btn-lg testbutton"><i class="glyphicon glyphicon-refresh"></i>&nbsp;复习本课程</button></a>
                <a href="{:U('Index/index')}"><button type="button" class="btn btn-primary btn-lg testbutton"><i class="glyphicon glyphicon-play-circle"></i>&nbsp;学习其他课程</button></a>
            </div>
        </div>
    </div>
</div>
<include file="beforestudytest.css"/>
</block>