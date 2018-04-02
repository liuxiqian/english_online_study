<extend name="Base:index" />
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <form action="{:U('index?keywords=', I('get.'))}" method="get">
                <div class="row">
                    <div class="col-md-2">
                        <select name="module" class="form-control">
                            <foreach name="M:getModules()" item="module">
                            <option value="{$module['module']}" <php>if (I('get.module') === $module['module']) echo 'selected="selected"';</php>>{$module['module']}</option>
                            </foreach>
                        <select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group custom-search-form">

                            <input class="form-control" name="keywords" placeholder="标题..." type="text" value="{:I('get.keywords')}" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-offset-5">
                        <a href="{:U('add?id=', I('get.'))}" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> 新增</a>
                    </div>
                </div>
            </form>
            <div class="box">
                <div class="box-body table-responsive">
                    <div class="panel-body" id="test">
                        
                    </div>
                    <!-- /input-group -->
                    <!-- Table -->
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>标题</th>
                                <th>开发</th>
                                <th>隐藏</th>
                                <th>开发时间</th>
                                <th>开发人</th>
                                <th>完成</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <foreach name="data" item="value" key="key">
                                <tr>
                                    <td>{$key+1}</td>
                                    <td>
                                        <a href="javascript:void(0);" data-trigger="focus" data-container="body" data-toggle="popover" data-title="{$value['module']}\{$value['controller']}\{$value['action']}" data-placement="right" data-content="{$value['abstract']}">
                                                                <php>
                                            for( $level = 0; $level
                                            < $value[ '_level']; $level++) echo "|----"; </php>
                                                {$value.title}
                                        </a>
                                    </td>
                                    <td>
                                        <eq name="value.development" value="0">否
                                            <else /><span class="badge">是</span></eq>
                                    </td>
                                    <td>
                                        <eq name="value.show" value="1">否
                                            <else /><span class="badge">是</span></eq>
                                    </td>
                                    <td>{$value["dev_time"]}</td>
                                    <td>{$value["dev_user"]}</td>
                                    <td><eq name="value['is_done']" value="1"><span class="badge">是</span><else />否</eq></td>
                                    <td>
                                        <a class="btn btn-md btn-primary" href="{:U('edit?id=' . $value['id'], I('get.'))}"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-md btn-danger" href="{:U('delete?id='.$value['id'], I('get.'))}"><i class="fa fa-trash-o "></i> 删除</a>
                                    </td>
                                </tr>
                            </foreach>
                        </tbody>
                    </table>
                </div>
                <nav>
                    <Yunzhi:page totalcount="totalCount" />
                </nav>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $(function(){
         $('[data-toggle="popover"]').popover();
    });
    </script>
</block>
