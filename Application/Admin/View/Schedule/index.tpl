<extend name="Base:index" />
<block name="title">
    进度查询
</block>
<block name="body">
    <div ng-app="mengyunzhi" ng-controller="vocabulary">
        <form action="" method="get">
            <div class="col-md-3">
                <div class="form-group input-group">
                    <span class="input-group-addon">班级</span>
                    <select name="klass_id" class="form-control">
                        <php>$klass_id = I('get.klass_id');</php>
                        <option value="0">全部班级</option>
                        <foreach name="M:getKlasses()" item="klass">
                            <option value="{$klass['id']}" <eq name="klass_id" value="$klass['id']">selected="selected"</eq>>{$klass['name']}</option>
                        </foreach>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group custom-search-form">
                    <input class="form-control" name="keywords" placeholder="姓名.." type="text" value="{:I('get.keywords')}" />
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i>
                    </button> 
                </span>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th><a href="">姓名</a></th>
                    <th>班级</th>
                    <th>学习次数</th>
                    <th>首次学习</th>
                    <th>上次学习</th>
                    <th>上次用时（分钟）</th>
                    <th>累计用时（分钟）</th>
                    <th>新学词汇</th>
                    <th>复习词汇</th>
                    <th>剩余词汇</th>
                    <th>进度</th>
                    <th>学习记录</th>
                    <th>测试记录</th>
                    <Yunzhi:access a="frozen">
                    <th>操作</th>
                    </Yunzhi:access>
                </tr>
            </thead>
            <tbody>
                <foreach name="M:getStudents()" item="list" key="key">
                    <tr class="odd gradeX">
                        <td><a href="{:U('detail?id='.$list['id'],I('get.'))}">{$list['name']}</a></td>
                        <td>{:$M->getKlassByKlassId($list['klass__id'])}</td>
                        <td>{:$M->getCountByStudentId($list['id'])}</td>
                        <td class="center">{:$M->getFristLoginByStudentId($list['id'])?date("Y-m-d",$M->getFristLoginByStudentId($list['id'])):0}</td>
                        <td class="center">{:$M->getLastLoginTimeByStudentId($list['id'])?date("Y-m-d",$M->getLastLoginTimeByStudentId($list['id'])):0}</td>
                        <td>{:$M->getTimeCostByStudentIdLoginId($list['id'],$M->getLastLoginIdByStudentId($list['id']))}</td>
                        <td>{:$M->getTotalTimeCostByStudentId($list['id'])}</td>
                        <td>{:$M->getNewWordCountByStudentId($list['id'])}</td>
                        <td>{:$M->getOldWordCountByStudentId($list['id'])}</td>
                        <td>{:$M->getSurplusWordByStudentId($list['id'])}</td>
                        <td>{:$M->getProgressByStudentId($list['id'])}%</td>
                        <td><Yunzhi:access a="studyrecord"><a href="{:U('studyrecord?id=' . $list['id'], I('get.'))}">查看</a><else />-</Yunzhi:access></td>
                        <td><Yunzhi:access a="testrecord"><a href="{:U('testrecord?id=' . $list['id'], I('get.'))}">查看</a><else />-</Yunzhi:access></td>
                        <Yunzhi:access a="frozen">
                            <td>
                                <a href="{:U('frozen?id='.$list['id'],I('get.'))}">
                                    <eq name="list['status']" value="0">
                                        <button type="button" class="btn btn-warning">冻结</button>
                                        <else/>
                                        <button type="button" class="btn btn btn-success">解冻</button>
                                    </eq>
                                </a>
                            </td>
                        </Yunzhi:access>
                    </tr>
                </foreach>
            </tbody>
        </table>
        <div class="row">
            <nav>
                <Yunzhi:page totalcount="M:totalCount" />
            </nav>
        </div>
    </div>
    <include file="index.js" />
</block>
