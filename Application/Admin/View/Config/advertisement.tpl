<extend name="Base:index" />
<block name="body">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" action="{:U('save',I('get.'))}" method='post' id="demoForm">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">图片</label>
                            <div class="col-sm-4">

                                <input  type="file" name="uploadFile" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-success" onclick="location='{:U(customer)}'"><i class="fa fa-check "></i> 确认</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>
