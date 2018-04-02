<extend name="Base:index" />
<block name="title">
    用户管理
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2 col-md-offset-10">
                    <a href="{:U(add)}" class="button btn btn-info"><i class="glyphicon glyphicon-plus"></i> 新增</a>
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
                                <th>姓名</th>
                                <th>教学区域</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>许元硕</td>
                                <td>广州区</td>
                                <td>
                                <button class="btn btn-sm btn-primary" onclick="location='{:U(add)}'"><i class="fa fa-pencil"></i> 编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="location='{$value._url.delete}'"><i class="fa fa-trash-o "></i> 删除</button>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-lock "></i> 冻结</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>金赫奎</td>
                                <td>天津</td>
                                <td>
                                <button class="btn btn-sm btn-primary" onclick="location='{:U(add)}'"><i class="fa fa-pencil"></i> 编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="location='{$value._url.delete}'"><i class="fa fa-trash-o "></i> 删除</button>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-lock "></i> 冻结</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>田野</td>
                                <td>上海</td>
                                <td>
                                <button class="btn btn-sm btn-primary" onclick="location='{:U(add)}'"><i class="fa fa-pencil"></i> 编辑</button>
                                <button class="btn btn-sm btn-danger" onclick="location='{$value._url.delete}'"><i class="fa fa-trash-o "></i> 删除</button>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-lock "></i> 冻结</button>
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

