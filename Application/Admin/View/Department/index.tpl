<extend name="Base:index" />
<block name="title">
    区域管理
</block>
<block name="body">
    <div class="row">
        <form action="" method="get">
            <div class="col-md-2">
                <select name="id" class="form-control">
                    <php>$id = I('get.id');</php>
                    <option value="0">全部区域</option>
                    <foreach name="datas" item="data">
                        <option value="{$data['id']}" <eq name="id" value="$data['id']">selected="selected"</eq>>{$data['title']}</option>
                    </foreach>
                </select>
            </div>
            <div class="col-md-3">
                <div class="input-group custom-search-form">
                <input class="form-control" name="keywords" placeholder="Search..." type="text" value="{:I('get.keywords')}" />
                <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                </span>
            </div>
        </form>
    </div>

    <div class="col-md-2 col-md-offset-7">
        <Yunzhi:access a="add"><a class="button btn btn-info" href="{:U('add', I('get.'))}"><i class="glyphicon glyphicon-plus"></i> 新增</a></Yunzhi:access>
    </div>
    <div class="panel-body">
    </div>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>区域</th>
                <th>是否总部</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="datas" item="data">
                <tr>
                    <td width="30%">{$data['title']}</td>
                    <td width="30%"><eq name="data['is_son']" value="1">否<else /><span class="badge">是</span></eq></td>
                    <td width="30%"><eq name="data['is_son']" value="1">
                    <Yunzhi:access a="add"><a class="btn btn-sm btn-primary" href="{:U('add?id='.$data['id'],I('get.'))}" ><i class="fa fa-pencil"></i> 编辑</a></Yunzhi:access>
                    <Yunzhi:access a="delete"><a class="btn btn-sm btn-danger" href="javascript:if(confirm('删除后无法恢复，请您确认'))location='{:U('delete?id='.$data['id'],I('get.'))}'" ><i class="fa fa-trash-o "></i> 删除</a></Yunzhi:access></eq>
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
</block>
