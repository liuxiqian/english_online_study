<extend name="Base:index" />
<block name="wrapper">
<div class="container-fluid">
    <div class="row-fluid">
        <div class="row">
            <div class="panel panel-default text-center">
            	<h2 class="text-center test">
            	你已经学完了本课程词汇。你可以复习本课程内词汇，也可以进行其他课程学习。
            	</h2>
    			<a href="{:U('Student/review')}"><button type="button" class="btn btn-primary btn-lg testbutton">复习本课程</button></a>
                <a href="{:U('Student/index')}"><button type="button" class="btn btn-primary btn-lg testbutton">学习其他课程</button></a>
            </div>
        </div>
    </div>
</div>
<include file="beforestudytest.css"/>
</block>