<extend name="Base:index" />
<block name="title">
    查看学生
</block>
<block name="body">
    <div class="col-md-12">
        <p style="text-align: center;font-size: 24px;">{$M->getKlassNameByKlassId($klass_id)}--------学生列表</p>
    </div>
    <div class="panel-body">
    </div>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>序号</th>
                <th>登录名</th>
                <th>姓名</th>
                <td>学习详情</td>
                <th>注册日期</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="datas" item="data" key="k">
                <tr>
                    <td width="10%">{$k+1}</td>
                    <td width="10%">{$data['username']}</td>
                    <td>{$data['name']}</td>
                    <td><a href="{:U('Schedule/detail?id=' . $data['id'])}">查看</a></td>
                    <td>{$data['creation_date'] | date="Y-m-d", ###}</td>
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
