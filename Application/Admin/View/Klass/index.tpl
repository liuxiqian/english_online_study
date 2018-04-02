<extend name="Base:index" />
<block name="title">
    班级管理
</block>
<block name="body">
    <form action="{:U('index')}" method='get'>
        <div class="col-md-3">
            <div class="form-group input-group">
                <span class="input-group-addon">教师</span>
                <select name="teacher_id" class="form-control">
                        <php>$teacher_id=I('get.teacher_id');</php>
                        <option value="0">全部教师</option>
                        <foreach name="M:getTeachers()" item="teacher">
                            <option value="{$teacher['id']}" <eq name="teacher_id" value="$teacher['id']">selected="selected"</eq>>{$teacher['name']}</option>
                        </foreach>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group custom-search-form">
                <input class="form-control" name="keywords" placeholder="班级.." type="text" value="{:I('get.keywords')}" />
                <span class="input-group-btn">
                    <Yunzhi:access a="index"><button class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i>
                    </button></Yunzhi:access>
                </span>
            </div>
        </div>

    </form>
    <div class="col-md-2 col-md-offset-4">
        <Yunzhi:access a="add"><a class="button btn btn-info" href="{:U('add')}"><i class="glyphicon glyphicon-plus"></i> 新增班级</a></Yunzhi:access>
    </div>
    <div class="panel-body"></div>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>序号</th>
                <th>班级</th>
                <th>教师</th>
                <th>当前人数</th>
                <th>创建日期</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="datas" item="data" key="k">
                <tr>
                    <td>{$k+1}</td>
                    <td>{$data['name']}</td>
                    <td>{$data['user__name']}</td>
                    <td>{$M->getCountById($data['id'])}</td>
                    <td>{$data['create_time'] | date="Y-m-d", ###}</td>
                    <td>
                        <Yunzhi:access a="add"><a class="btn btn-sm btn-primary" href="{:U('add?id='.$data['id'],I('get.'))}"><i class="fa fa-pencil"></i>&nbsp;编辑</a></Yunzhi:access>
                        <Yunzhi:access a="delete"><a class="btn btn-sm btn-danger" href="{:U('delete?id='.$data['id'], I('get.'))}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></Yunzhi:access>
                        <Yunzhi:access a="viewStudent"><a class="btn btn-sm btn-success" href="{:U('viewStudent?klass_id='.$data['id'],I('get.'))}"><i class="fa  fa-edit"></i>&nbsp;查看学生</a></Yunzhi:access>
                        <Yunzhi:access a="assignCourse"><a class="btn btn-sm btn-warning" href="{:U('assignCourse?klass_id='.$data['id'],I('get.'))}"><i class="glyphicon glyphicon-edit"></i>&nbsp;查看课程</a></Yunzhi:access>
                        <Yunzhi:access a="articleIndex"><a class="btn btn-sm btn-info" href="{:U('articleIndex?klass_id='.$data['id'], I('get.'))}"><i class="glyphicon glyphicon-edit"></i>&nbsp;阅读闯关</a></Yunzhi:access>

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
