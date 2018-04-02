<extend name="Base:index" />
<block name="body">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    新增
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{:U('save',I('get.'))}" method='post' id="demoForm">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="name" value="{$data.name}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">角色</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="title" value="{$data.title}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">权限</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="title" value="{$data.title}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="title" >
                                <option>正常</option>
                                <option>冻结</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-success" onclick="{:U(customer)}"><i class="fa fa-check "></i> 确认</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</block>
