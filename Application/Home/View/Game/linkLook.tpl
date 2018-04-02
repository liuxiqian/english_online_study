<extend name="Base:index" />
<block name="wrapper">
    <include file="linkLook.css" />
    <div class="container" id="main">
        <div class="row">
            <div class="col-md-8 col-md-offset-1" id="main_m">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2" id="main_m1">
                        <div class="row">
                            <div class="text-center">
                            <h1 class="title">单词连连看</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2">
                            <a href="{:U('Game/linkLookHome?courseId=' . I('get.courseId'))}" type="button" class="btn btn-success btn-lg btn-block" style="margin-top:100px;margin-left:120px;width:60%;" >开始&nbsp;Start</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</block>
</extend>
