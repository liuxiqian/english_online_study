<extend name="Base:index" />
<block name="wrapper">
<div class="container-fluid">
    <div class="row-fluid">
        <div class="row">
            <div class="panel panel-default text-center">
            	<h2 class="text-center test">
            	你已经学完了本组词汇。你可以复习本组内词汇，也可以进行组测试。组测试检查你对本组词汇的掌握情况。组测试的正确率要求是：80%。通过组测试后，你可以继续学习。
            	</h2>
    			<a href="{:U('Student/review')}"><button type="button" class="btn btn-primary btn-lg testbutton">复习本课程</button></a>
                <a href="{:U('Index/wordTest')}"><button type="button" class="btn btn-primary btn-lg testbutton">组测试</button></a>
            </div>
        </div>
    </div>
</div>
<include file="beforestudytest.css"/>
</block>