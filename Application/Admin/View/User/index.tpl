<extend name="Base:index" />
<block name="title">
    用户管理
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="row">
                <form action="{:U('index?keywords=')}" method="get">
                    <div class="col-md-3">
                        <div class="form-group input-group">
                            <span class="input-group-addon">区域</span>
                            <select name="department_id" class="form-control">
                                <php>$department_id = I('get.department_id');</php>
                                <option value="0">全部区域</option>
                                <foreach name="M:getCurrentUserAllowedDepartment()" item="data">
                                    <option value="{$data['id']}" <eq name="department_id" value="$data['id']">selected="selected"</eq>>{$data['title']}</option>
                                </foreach>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group input-group">
                            <span class="input-group-addon">岗位</span>
                            <select name="post_id" class="form-control">
                                <php>$post_id = I('get.post_id');</php>
                                <option value="0">全部岗位</option>
                                <foreach name="M:getCurrentUserPosts()" item="data">
                                    <option value="{$data['id']}" <eq name="post_id" value="$data['id']">selected="selected"</eq>>{$data['name']}</option>
                                </foreach>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group custom-search-form">
                            <input class="form-control" name="keywords" placeholder="姓名" type="text" value="{:I('get.keywords')}" />
                            <span class="input-group-btn">
                                <Yunzhi:access a="index"><button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button></Yunzhi:access>
                            </span>
                        </div>
                    </div>
                </form>
                <div class="col-md-2">
                    <Yunzhi:access a="add"><a class="button btn btn-info" href="{:U('add', I('get.'))}"><i class="glyphicon glyphicon-plus"></i> 新增</a></Yunzhi:access>
                </div>
            </div>
            <div class="box">
                <div class="box-body table-responsive">
                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <?php $order=I('get.order') ?>
                                    <th>
                                        <a href="<eq name='order' value=" desc "> {:U('index?by=username&order=asc', I('get.'))}
                                 <else/> {:U('index?by=username&order=desc', I('get.'))} </eq>">用户名</a>
                                    </th>
                                    <th>姓名</th>
                                    <th>区域</th>
                                    <th>岗位</th>
                                    <th>手机号</th>
                                    <th>邮箱</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <foreach name="M:getCurrentUserLists()" item="data" key="k">
                                    <tr>
                                        <td>{$k+1}</td>
                                        <td>{$data['username']}</td>
                                        <td>{$data['name']}</td>
                                        <td>{$data['department__title']}</td>
                                        <td>{$data['post__title']}</td>
                                        <td>{$data['phonenumber']}</td>
                                        <td>{$data['email']}</td>
                                        <td>
                                            <Yunzhi:access a="edit"><a class="btn btn-sm btn-primary" href="{:U('edit?id='.$data['id'], I('get.'))}"><i class="fa fa-pencil"></i>&nbsp;编辑</a></Yunzhi:access>
                                            <Yunzhi:access a="delete"><a class="btn btn-sm btn-danger" href="javascript:if(confirm('删除后无法恢复，请您确认'))location='{:U('delete?id='.$data['id'], I('get.'))}'"><i class="fa fa-trash-o "></i>&nbsp;删除</a></Yunzhi:access>
                                            <Yunzhi:access a="resetPassword"><a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$data['id'], I('get.'))}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a></Yunzhi:access>
                                        </td>
                                    </tr>
                                </foreach>
                            </tbody>
                        </table>
                    </div>
                </div>
                <nav>
                    <Yunzhi:page totalcount="M:totalCount" />
                </nav>
            </div>
        </div>
    </div>
</block>
