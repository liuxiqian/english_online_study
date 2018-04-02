<extend name="Base:index" />
<block name="title">
教务员管理
</block>
<block name="body">
<div class="row-fluid">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-3">
                    <form action="{:U('index?keywords=')}" method="get">
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
                <div class="col-md-3">
                    <a class="button btn btn-primary"  href="{:U('edit')}" ><i class="glyphicon glyphicon-plus"></i> 添加用户</a>
                </div>
            </div>
            <div class="box">
                <div class="box-body table-responsive">
                    <div class="panel-body">
                    </div>

                    <table class = "table table-bordered table-striped table-hover">
	                    <thead>
	                        <tr>
                                <th>序号</th>
                                <?php $order=I('get.order') ?>
			                    <th>
			                    <a href="<eq name='order' value="desc"> {:U('index?by=username&order=asc', I('get.'))}  
			                    <else/> {:U('index?by=username&order=desc', I('get.'))} </eq>">用户名</a>
			                    </th>
                                <th>电话</th>
			                    <th>绑定班级</th>
			                    <th>操作</th>
		                    </tr>
	                    </thead>
	                    <tbody>		                 
			                    <tr>
				                    <td>1</td>
                                    <td>张佳豪</td>
                                    <td>18812669566</td>
				                    <td>133班</td>
				                    <td>
				                    <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$user['id'])}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
				                    <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$user['id'])}"><i class="fa fa-trash-o "></i>&nbsp;删除</a>
				                    <a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$user['id'])}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a>
				                    </td>				                 
                                </tr>
	                    </tbody>
                        <tbody>                      
                                <tr>
                                    <td>2</td>
                                    <td>张佳豪</td>
                                    <td>18812669566</td>
                                    <td>133班</td>
                                    <td>
                                    <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$user['id'])}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                                    <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$user['id'])}"><i class="fa fa-trash-o "></i>&nbsp;删除</a>
                                    <a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$user['id'])}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a>
                                    </td>                                
                                </tr>
                        </tbody>
                        <tbody>                      
                                <tr>
                                    <td>3</td>
                                    <td>张佳豪</td>
                                    <td>18812669566</td>
                                    <td>133班</td>
                                    <td>
                                    <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$user['id'])}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                                    <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$user['id'])}"><i class="fa fa-trash-o "></i>&nbsp;删除</a>
                                    <a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$user['id'])}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a>
                                    </td>                                
                                </tr>
                        </tbody>
                        <tbody>                      
                                <tr>
                                    <td>4</td>
                                    <td>张佳豪</td>
                                    <td>18812669566</td>
                                    <td>133班</td>
                                    <td>
                                    <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$user['id'])}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                                    <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$user['id'])}"><i class="fa fa-trash-o "></i>&nbsp;删除</a>
                                    <a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$user['id'])}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a>
                                    </td>                                
                                </tr>
                        </tbody>
                        <tbody>                      
                                <tr>
                                    <td>5</td>
                                    <td>张佳豪</td>
                                    <td>18812669566</td>
                                    <td>133班</td>
                                    <td>
                                    <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$user['id'])}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                                    <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$user['id'])}"><i class="fa fa-trash-o "></i>&nbsp;删除</a>
                                    <a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$user['id'])}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a>
                                    </td>                                
                                </tr>
                        </tbody>
                        <tbody>                      
                                <tr>
                                    <td>6</td>
                                    <td>张佳豪</td>
                                    <td>18812669566</td>
                                    <td>133班</td>
                                    <td>
                                    <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$user['id'])}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                                    <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$user['id'])}"><i class="fa fa-trash-o "></i>&nbsp;删除</a>
                                    <a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$user['id'])}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a>
                                    </td>                                
                                </tr>
                        </tbody>
                        <tbody>                      
                                <tr>
                                    <td>7</td>
                                    <td>张佳豪</td>
                                    <td>18812669566</td>
                                    <td>133班</td>
                                    <td>
                                    <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$user['id'])}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                                    <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$user['id'])}"><i class="fa fa-trash-o "></i>&nbsp;删除</a>
                                    <a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$user['id'])}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a>
                                    </td>                                
                                </tr>
                        </tbody>
                        <tbody>                      
                                <tr>
                                    <td>8</td>
                                    <td>张佳豪</td>
                                    <td>18812669566</td>
                                    <td>133班</td>
                                    <td>
                                    <a class="btn btn-sm btn-primary" href="{:U('edit?id='.$user['id'])}"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
                                    <a class="btn btn-sm btn-danger" href="{:U('delete?id='.$user['id'])}"><i class="fa fa-trash-o "></i>&nbsp;删除</a>
                                    <a class="btn btn-sm btn-warning delete" href="{:U('resetPassword?id='.$user['id'])}"><i class="fa fa-repeat"></i>&nbsp;重置密码</a>
                                    </td>                                
                                </tr>
                        </tbody>
                    </table>

                </div>
                <nav>
                    <Yunzhi:page />
                </nav>

            </div>
        </div>
    </div>
</block>