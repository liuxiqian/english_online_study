<extend name="Base:index" />
<block name="title">
    日志管理
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <div class="panel-body" id="test">

                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>文件名</th>
                                <th>修改日期</th>
                                <th>文件大小</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <foreach name="M:getLists()" key="key" item="File">
                                <tr>
                                    <td>{$key+1}</td>
                                    <td>{$File->getFilename()}</td>
                                    <td>{:date("Y-m-d",$File->getModifiTime())}</td>
                                    <td>{:(int)($File->getSize() / 1024)}K</td>
                                    <td><Yunzhi:access a="download"><a target="_blank" class="btn btn-sm btn-primary" href="{:U('download?filename=' . $File->getFilename(), I('get.'))}"><i class="fa fa-share"></i>&nbsp;导出</a></Yunzhi:access></td>
                                </tr>
                            </foreach>
                        </tbody>
                    </table>
                    <nav>
                        <Yunzhi:page totalcount="M:getTotalCount()" />    
                    </nav>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</block>
