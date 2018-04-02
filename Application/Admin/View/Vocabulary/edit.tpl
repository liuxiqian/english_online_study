<extend name="Base:index" />
<block name="body">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <form class="form-horizontal" action="{:U('save',I('get.'))}" method='post' id="demoForm">
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">词汇</label>
                            <div class="col-md-4">
                                <input class="form-control" name="name" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-2 control-label">词性</label>
                            <div class="col-md-4">
                                <input class="form-control" name="title" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-2 control-label">音标(美)</label>
                            <div class="col-md-4">
                                <input class="form-control" name="title" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-2 control-label">音标(英)</label>
                            <div class="col-md-4">
                                <input class="form-control" name="title" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-2 control-label">例句</label>
                            <div class="col-md-4">
                                <input class="form-control" name="title" placeholder="">
                            </div>
                        </div>
                        <div class="form-group uploadify">
                            <div id="queue"></div>
                            <label for="title" class="col-md-2 control-label">上传图片</label>
                            <div class="col-md-4">
                                <input id="file" name="filename" type="file" multiple="true" value="上传图片">
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <span>(如果您看到的图片过大，那么将影响学习平台的加载速度，建议您用QQ截图等软件进行二次处理)</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-success" onclick="location='{:U(index)}'"><i class="fa fa-check "></i> 确认</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>
