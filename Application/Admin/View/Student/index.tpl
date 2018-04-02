<extend name="Base:index"/>
<block name="title">
    学生管理
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="row">
                <form action="{:U('index?keywords=')}" method="get">
                    <div class="col-md-2">
                        <input class="form-control" name="keywords" placeholder="姓名..." type="text"
                               value="{:I('get.keywords')}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="klassId">
                                <option value="0">请选择</option>
                            <foreach name="Klasses" item="_klass">
                                <option  <php> if (I('klassId') == $_klass->getId()) echo 'selected="selected"';</php> value="{:$_klass->getId()}">{:$_klass->getName()}</option>
                            </foreach>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-default" type="submit">
                            <i class="fa fa-search">
                            </i>&nbsp;查询
                        </button>
                    </div>
                </form>
                <div class="col-md-3">
                    <Yunzhi:access a="add"><a class="button btn btn-info" href="{:U('add')}"><i
                                    class="glyphicon glyphicon-plus"></i>新增学生</a></Yunzhi:access>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
    </div>
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
            <tr>
                <th>序号</th>
                <th>账号</th>
                <th>姓名</th>
                <th>班级</th>
                <th>进度</th>
                <th>家长电话</th>
                <th>注册日期</th>
                <eq name="M:isRegionAdmin()" value="1">
                    <th>有效期至</th>
                </eq>
                <th>学习记录</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <foreach name="M:getStudents()" item="list" key="key">
                <tr>
                    <td>{$key+1}</td>
                    <td>{$list['username']}</td>
                    <td>{$list['name']}</td>
                    <td>{:$M->getKlassByKlassId($list['klass__id'])}</td>
                    <td>{:$M->getProgressByStudentId($list['id'])}</td>
                    <td>{$list['phonenumber']}</td>
                    <td>{:date("Y-m-d",$list['creation_date'])}</td>
                    <eq name="M:isRegionAdmin()" value="1">
                        <td>{:date("Y-m-d", $Student->getDeadLine())}
                        </td>
                    </eq>
                    <td><a href="{:U('Schedule/detail?id=' . $list['id'], I('get.'))}">查看</a></td>
                    <td>
                        <Yunzhi:access a="edit"><a class="btn btn-sm btn-primary"
                                                   href="{:U('edit?id='.$list['id'],I('get.'))}"><i
                                        class="fa fa-pencil"></i>&nbsp;编辑</a></Yunzhi:access>
                        <Yunzhi:access a="resetPassword"><a class="btn btn-sm btn-info delete"
                                                            href="{:U('resetPassword?id='.$list['id'],I('get.'))}"><i
                                        class="fa fa-repeat"></i>&nbsp;重置密码</a></Yunzhi:access>
                        <Yunzhi:access a="frozen"><a href="{:U('frozen?id='.$list['id'],I('get.'))}">
                                <eq name="list['status']" value="0">
                                    <button type="button" class="btn btn-warning">冻结</button>
                                    <else/>
                                    <button type="button" class="btn btn btn-success">解冻</button>
                                </eq>
                            </a></Yunzhi:access>
                    </td>
                </tr>
            </foreach>
            </tbody>
        </table>
    </div>
    <nav>
        <Yunzhi:page totalcount="M:totalCount" pagesize="pagesize"/>
    </nav>
    <include file="index.js"/>
</block>
