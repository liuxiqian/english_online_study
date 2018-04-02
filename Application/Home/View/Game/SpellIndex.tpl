<extend name="Base:index" />
<block name="wrapper">
<include file="SpellIndex.css" />
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="jumbotron  background1">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="jumbotron  background2">
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-4">
                                    <h2 class="title">拼写高手</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-4">
                                    <a href="{:U('Game/SpellHome?courseId=' . I('get.courseId'))}" type="button" class="btn btn-success btn-lg btn-block">
                                        开始游戏</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</block>
</extend>
