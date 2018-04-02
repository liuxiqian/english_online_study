<extend name="Base:index" />
<block name="title">
    阅读闯关
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <a href="{:U('add?id', I('get.'))}" class="button btn btn-info"><i class="glyphicon glyphicon-plus"></i>新增</a>
                </div>
            </div>
            <div class="panel-body">
            </div>
            <div class="row">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>序号</th>
                        <th>标题</th>
                        <th>操作</th>
                    </tr>
                    <foreach name="Article:getLists()" item="article" key="key">
                        <tr>
                            <td>{$key+1}</td>
                            <td>{:$article->getTitle()}</td>
                            <td>
                                <Yunzhi:access a="edit"><a class="btn btn-sm btn-primary" href="{:U('edit?id=' . $article->getId(), I('get.'))}"><i class="fa fa-pencil "></i>&nbsp;编辑</a></Yunzhi:access>
                                <Yunzhi:access a="delete"><a class="btn btn-sm btn-danger" href="{:U('delete?id=' . $article->getId(), I('get.'))}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></Yunzhi:access>
                            </td>
                        </tr>
                    </foreach>
                </table>
            </div>
            <Yunzhi:page totalCount="Article:getTotalCount()" />
        </div>
    </div>
</block>
