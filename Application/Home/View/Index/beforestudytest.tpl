<extend name="Base:index" />
<block name="wrapper">
<div class="container-fluid">
    <div class="row-fluid">
        <div class="row">
            <div class="panel panel-default text-center">
            	<h2 class="text-center test">
            	在正式爆破你的词汇之前，请参加学前测试，测试结果将
            	</h2>
            	<h2 class="text-center">
            		有助于我们了解你对本教材词汇的掌握情况。
            	</h2>
    			<a href="{:U('wordTest')}"><button type="button" class="btn btn-warning btn-lg testbutton">进行学前测试</button></a>
            </div>
        </div>
    </div>
</div>
<include file="beforestudytest.css"/>
</block>