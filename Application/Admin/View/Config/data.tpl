<extend name="Base:index" />
<block name="title">
    数据管理
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <a href="{:U(add)}" class="button btn btn-info"><i class="fa fa-pencil"></i> 备份当前数据</a>
                </div>
            </div>
            <div class="box">
                <div class="box-body table-responsive">
                    <div class="panel-body" id="test">

                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>序号</th>
                                <td>备份大小</td>
                                <td>备份日期</td>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>一半空间</td>
                                <td>2016.03.01</td>
                                <td>
                                <a class="btn btn-sm btn-primary" href="{$value._url.delete}"><i class="fa fa-share "></i> 导出</a>
                                <a class="btn btn-sm btn-danger" href="{$value._url.edit}"><i class="fa fa-trash-o "></i> 删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>三分之一空间</td>
                                <td>2016.03.01</td>
                                <td>
                                <a class="btn btn-sm btn-primary" href="{$value._url.delete}"><i class="fa fa-share "></i> 导出</a>
                                <a class="btn btn-sm btn-danger" href="{$value._url.edit}"><i class="fa fa-trash-o "></i> 删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>四分之一空间</td>
                                <td>2016.03.01</td>
                                <td>
                                <a class="btn btn-sm btn-primary" href="{$value._url.delete}"><i class="fa fa-share "></i> 导出</a>
                                <a class="btn btn-sm btn-danger" href="{$value._url.edit}"><i class="fa fa-trash-o "></i> 删除</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</block>
