<extend name="Base:index" />
<block name="title">
    卡密管理
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="row">
                <form action="{:U('index?keywords=')}" method='get'>
                    <div class="col-md-3">
                        <div class="input-group custom-search-form">
                            <input class="form-control" name="keywords" placeholder="批次.." type="text" value="{:I('get.keywords')}" />
                            <span class="input-group-btn">
                            <Yunzhi:access a="index"><button class="btn btn-default" type="submit">
                                <i class="fa fa-search"></i>
                            </button></Yunzhi:access>
                            </span>
                        </div>
                    </div>
                </form>
                <div class="col-md-2 pull-right">
                    <a href="{:U('add')}" class="button btn btn-info"><i class="glyphicon glyphicon-plus"></i> 生成新卡密</a>
                </div>
            </div>
            <div class="box">
                <div class="box-body">
                    <div class="panel-body" id="test">
                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>批次</th>
                                <th>生成个数</th>
                                <th>已使用个数</th>
                                <th>生成日期</th>
                                <th>有效期天数</th>
                                <th>截止日期</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <foreach name="M:getCardBatchLists()" item="data" key="k">
                                <tr>
                                    <td>{$k+1}</td>
                                    <td>{$data['batch']}</td>
                                    <td>{:$M->getCardNumberByCardBatchId($data['id'])}</td>
                                    <td>{:$M->getCardIsUseNumberByCardBatchId($data['id'])}</td>
                                    <td>{$data['generate_date'] | date='Y-m-d',###}</td>
                                    <td>{$data['effective_days']}</td>
                                    <td>{$data['deadline'] | date='Y-m-d',###}</td>
                                    <td><eq name="M:isExist($data['batch'])" value="true">
                                        <a class="btn btn-sm btn-primary" href="__ROOT__/{$data['url']}.xls"><i class="fa fa-download "></i>&nbsp;下载</a>
                                        <Yunzhi:access a="delete"><a class="btn btn-sm btn-danger" href="{:U('delete?filename=' . $data['batch'], I('get.'))}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></Yunzhi:access><else />已删除</eq>
                                    </td>
                                </tr>
                            </foreach>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
                <div class="row">
                    <nav>
                        <Yunzhi:page totalcount="totalCount" />
                    </nav>
                </div>
            </div>
        </div>
    </div>
</block>
