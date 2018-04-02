<extend name="Base:index" />
<block name="wrapper">

<div class="container" ng-app="myApp" ng-controller="WordTest">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-offset-2">
                    <a class="btn btn-sm btn-primary" href="{:U('dictation')}">听写题</a>
                    <a class="btn btn-sm btn-primary pull-right" href="">我要交卷</a>
                </div>
            </div>
        </div>
    </div>
   <!--  第一行文字显示 -->
    <div class="row">
        <div class="col-md-offset-1">
        <h4>说明：请点击喇叭按钮，听到读音后，选择听到的词汇。（共6题）</h4>
        </div>
    </div>
        <!-- 设置下方的组测试格式 -->
    <div class="row">
        <div class="col-md-11">
            <div class="row">            
                <div class="col-md-offset-1 col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>1.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                 <input class="form-control" name="name" ><br /> 
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>2.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                 <input class="form-control" name="name" ><br /> 
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>3.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                 <input class="form-control" name="name" ><br /> 
                            </form>                    
                        </div>
                    </div>
                </div>
                <!-- 右方浮动框（只是效果图） -->
                <div class="col-md-2">
                    <div class="list-group">
                        <a href="#" class="list-group-item active">
                            <h4 class="list-group-item-heading">剩余时间</h4>
                            <h4><font color="red">{{mum | secondFormat}}</font></h4>
                            <h4 class="list-group-item-heading">未完成题数</h4>
                            <h4><font color="red">15</font></h4>
                        </a>                          
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row height">
        <div class="col-md-12">
        </div>
    </div>

    <div class="row">
        <div class="col-md-11">
            <div class="row">            
                <div class="col-md-offset-1 col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>4.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                 <input class="form-control" name="name" ><br /> 
                            </form>                 
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>5.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                 <input class="form-control" name="name" ><br /> 
                            </form>              
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>6.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                 <input class="form-control" name="name" ><br /> 
                            </form>                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p> </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-offset-2">
                    <a class="btn btn-sm btn-primary" href="{:U('dictation')}">听写题</a>
                    <a class="btn btn-sm btn-primary pull-right" href="">我要交卷</a>
                </div>
            </div>
        </div>
    </div>
<include file="test.css"/>
<include file="test.js"/>
</block>