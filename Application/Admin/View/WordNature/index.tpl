<extend name="Base:index" />
<block name="title">
    单词扩展属性管理
</block>
<block name="body">
    <div class="col-md-3">
        <a class="button btn btn-info" href="{:U('add')}"><i class="glyphicon glyphicon-plus"></i> 新增</a>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>属性名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <foreach name="datas" item="data" key="k">
                    <tr>
                        <td>{$k+1}</td>
                        <td>{$data['name']}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$data['id'],I('get.'))}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                            <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$data['id'],I('get.'))}"><i class="fa fa-trash-o"></i>&nbsp;删除</a>
                        </td>
                    </tr>
                </foreach>
            </tbody>
        </table>
        <div class="row">
            <nav>
                <Yunzhi:page />
            </nav>
        </div>
    </div>
</block>
