<extend name="Base:index" />
<block name="wrapper">

<div class="container" ng-app="myApp" ng-controller="WordTest">
    <div class="row">
        <div class="col-md-9">
            <div class="row">            
                <div class="col-md-offset-1">
                    <a class="btn btn-sm btn-primary" href="{:U('cinterpretation')}">释义题</a>
                    <a class="btn btn-sm btn-primary" href="{:U('comprehensive')}">听辨题</a>
                    <a class="btn btn-sm btn-primary" href="{:U('cdictation')}">听写题</a>
                    <a class="btn btn-sm btn-primary pull-right" href="">提交</a>
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
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    parrot
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    Australian
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    more than
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    special
                                </label><br /> 
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>2.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    pet
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    come true
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    fail
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    Martin Luther King
                                </label><br /> 
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>3.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    monster
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    strange
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    in the future
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    consequence
                                </label><br /> 
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
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    fictionally
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    hometown
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    fiction
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    predict
                                </label><br /> 
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>5.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    whether
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    important
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    good
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    significant
                                </label><br /> 
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-11" style="background:#FFFF99">
                            <h4>6.&nbsp<a href=""><span class=" glyphicon glyphicon-volume-up" aria-hidden="true"></span></a></h4> 
                            <form>
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    value
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    fast
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    typist
                                </label><br />
                               <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                    Italian
                                </label><br /> 
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
        <div class="col-md-10">
            <div class="row">            
                <div class="col-md-offset-2">
               <button type="button" class="col-md-offset-10 btn btn-success ">提交</button>     
                </div>
            </div>
        </div>
    </div>
    
</div>
<include file="test.css"/>
<include file="test.js"/>
</block>