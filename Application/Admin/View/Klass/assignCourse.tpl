<extend name="Base:index" />
<block name="title">
    分配课程
</block>
<block name="body">
    <div class="row">
        <div class="col-md-2 col-md-offset-10">
            <Yunzhi:access a="addCourse"><a class="button btn btn-info" href="{:U('addCourse',I('get.'))}"><i class="glyphicon glyphicon-plus"></i>&nbsp;新增课程</a></Yunzhi:access>
        </div>
    </div>
    <div class="col-md-12">
        <p style="text-align: center;font-size: 24px;">{$M->getKlassNameByKlassId($klass_id)}--------添加课程列表</p>
    </div>
    <div class="panel-body">
    </div>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th width="80%">课程名</th>
                <th width="20%">操作</th>
            </tr>
        </thead>
        <tbody>
        <foreach name="datas" item="data">
            <tr>
                <td>{$data['title']}</td>
                <td>
                    <Yunzhi:access a="deleteCourse"><a class="button btn btn-sm btn-danger" href="{:U('deleteCourse?course_id='.$data['course_id'],I('get.'))}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></Yunzhi:access>
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
