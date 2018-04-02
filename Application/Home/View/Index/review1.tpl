<extend name="Base:index" />
<block name="wrapper">
<div class="container-fluid">
    <div class="row-fluid">
        <div class="row">
            <div class="panel panel-default text-center">
            	<h2 class="text-center test">
            	你可以复习学过的词汇，也可以进行阶段测试。
            	</h2>
    			<a href="{:U('Student/review')}"><button type="button" class="btn btn-primary btn-lg testbutton">复习本课程</button></a>
                <a href="{:U('Index/wordTest')}"><button type="button" class="btn btn-primary btn-lg testbutton">阶段测试</button></a>
            </div>
        </div>
    </div>
</div>
<include file="beforestudytest.css"/>
</block>