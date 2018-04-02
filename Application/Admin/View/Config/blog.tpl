<extend name="Base:index" />
<block name="title">
    日志管理
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-xm-12">
            <div class="row">

            </div>
            <div class="box">
                <div class="box-body table-responsive">
                    <div class="panel-body" id="test">

                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>序号</th>
                                <th>时间</th>
                                <th>用户名</th>
                                <th>IP地址</th>
                                <th>触发器</th>
                                <th>控制器</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2016.03.01</td>
                                <td>tc001</td>
                                <td>127.0.0.1</td>
                                <td>Index触发器</td>
                                <td>index控制器</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2016.02.01</td>
                                <td>tc001</td>
                                <td>127.0.0.1</td>
                                <td>Save触发器</td>
                                <td>save控制器</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>2016.01.01</td>
                                <td>tc001</td>
                                <td>127.0.0.1</td>
                                <td>Update触发器</td>
                                <td>update控制器</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</block>
