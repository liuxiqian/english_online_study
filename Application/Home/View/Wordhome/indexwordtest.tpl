<extend name="Base:index" />
<block name="wrapper">
<div class="container-fluid" ng-app="Home" ng-controller="index">
    <div class="row-fluid">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body change">
                    <div class="col-md-9">
                        <div class="row">
                        <div class="col-md-2">
                            <a href="{:U('Index/review0')}" class="btn btn-success btn-lg" role="button">词汇记忆
                            <span class="glyphicon glyphicon-play-circle"></span>
                            </a>  
                        </div>
                        <div class="col-md-2">
                        <a href="{:U('Index/wordTest')}" class="btn btn-warning btn-lg" role="button">组测试
                          <span class="glyphicon glyphicon-play-circle"></span>
                        </a>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                         新学110词，复习44词，共354词
                        </div>
                        <div class="row progress">
                            <div class="progress-bar progress-bar-warning" style="width: 10%">
                            <span class="sr-only">10% Complete (success)</span>
                            </div>
                            <div class="progress-bar progress-bar-primary progress-bar-striped" style="width: 20%">
                                <span class="sr-only">20% Complete (warning)</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-2">
                        <h1 style="color: red; margin-top: 0px;">93</h1>
                        </div>    
                        </div>
                        <div class="row">
                        <div ng-show="relationPicture" class="col-md-6 jumbotron" style="padding-bottom: 144px; padding-top: 125px;">
                            <h1 uib-popover="v.牢记,记住;" popover-title="[rɪˈmembə(r)]" popover-trigger="mouseenter" ng-click="example()">remember</h1>
                            <p ng-show="exampleWord">同义词</p>
                            <p ng-show="exampleWord">反义词</p>
                        </div>
                        <div class="col-md-5">
                            <div class="list-group in_c">
                                <a href="#" class="list-group-item active">
                                    难词
                                </a>
                                <a href="{:U('Index/wordDetail')}" class="list-group-item text-center">remember</a>
                                <a href="#" class="list-group-item text-center">Morbi</a>
                                <a href="#" class="list-group-item text-center">Porta</a>
                                <a href="#" class="list-group-item text-center">Vestibulum</a>
                                <a href="#" class="list-group-item text-center">Dapibus</a>
                                <a href="#" class="list-group-item text-center">Morbi</a>
                                <a href="#" class="list-group-item text-center">Porta</a>
                                <a href="#" class="list-group-item text-center">Vestibulum</a>
                                <a href="#" class="list-group-item text-center">Vestibulum</a>
                                <a href="#" class="list-group-item text-center">Vestibulum</a>
                                <a href="#" class="list-group-item text-center">Dapibus</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="list-group">
                                <li class="list-group-item active">词汇量排名</li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="__IMG__/n_01.gif">
                                        </div>
                                        <div class="text-left col-md-3">    
                                            <img class="media-object headpicture" src="__IMG__/liming.jpg">
                                        </div>
                                        <div class="text-center col-md-3">
                                            <h4>李明</h4>     
                                        </div>
                                        <div class="text-right">
                                            <h4>70</h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item text-right listfooter">我的词汇量：70    排名：1
                                </li>  
                                <li class="list-group-item active">学习速度排名(词/天)</li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="__IMG__/n_01.gif">
                                        </div>
                                        <div class="text-left col-md-3">    
                                            <img class="media-object headpicture" src="__IMG__/liming.jpg">
                                        </div>
                                        <div class="text-center col-md-3">
                                            <h4>李明</h4>     
                                        </div>
                                        <div class="text-right">
                                            <h4>0</h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item text-right listfooter">我的速度：0    排名：1
                                </li>   
                                <li class="list-group-item active">排名统计时间：2016-03-22 01:59</li> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="list-group">
                                <li class="list-group-item active">我的学习榜样</li>
                                <li class="list-group-item">
                                    <a href="{:U('Hero/index')}">指定一个学习榜样吧</a>
                                </li>  
                                
                            </div>
                        </div>  

                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<include file="index.js"/>
<style type="text/css">
    .headpicture{
        height: 50px;
    }
    h4{
        color: red;
    }
    .in_c{
         background:url(__IMG__/i_nc_c.gif) repeat-y;
    }
    .listfooter{
        background-color: #FBF9F9;
    }
    
</style>
</block>