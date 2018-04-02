<extend name="Base:index" />
<block name="title">
    测试查询
</block>
<block name="body">
    <form action="" method="get">
        <div class="panel-body" ng-controller="addTest">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group input-group">
                        <span class="input-group-addon">班级</span>
                        <select name="klass_id" class="form-control">
                            <php>$klass_id = I('get.klass_id');</php>
                            <option value="0">全部班级</option>
                            <foreach name="M:getKlasses()" item="klass">
                                <option value="{$klass['klass__id']}" <eq name="klass_id" value="$klass['klass__id']">selected="selected"</eq>>{$klass['klass__name']}</option>
                            </foreach>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group custom-search-form">
                        <div class="form-group input-group">
                            <span class="input-group-addon">选择日期</span>
                            <input class="form-control datetimepicker" name="time" type="text" value="{:I('get.time') ? I('get.time') : date('Y-m-d')}" placeholder="" data-date-format="yyyy-mm-dd" />
                        </div>
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
                <Yunzhi:access a="excelAjax">
                    <div ng-show="load" class="col-md-1 pull-right">
                    <button type="button" class="btn btn-md btn-success" ng-click="excel()" ng-disabled="disabled"><i class="fa fa-check"></i> 生成</button>
                    </div>
                </Yunzhi:access>
                 <Yunzhi:access a="download">
                    <div ng-hide="load" class="col-md-1 pull-right">
                    <a href="{:U('download')}" class="button btn btn-info"><i class="fa fa-share"></i> 导出</a>
                    </div>
                </Yunzhi:access>
            </div>
        </div>
    </form>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>班级</th>
                <th>姓名</th>
                <th>测试（组）</th>
                <th>学前（%）</th>
                <th>学后（%）</th>
                <th>新学单词（个）</th>
                <th>复习单词（个）</th>
                <th>所学课程</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="M:getStudents()" item="data">
                <tr>
                    <td>{$data['klass__name']}</td>
                    <td>{$data['name']}</td>
                    <td>{:$M->getTestCountByStudentId($data['id'])}</td>
                    <td>{:$M->getLearnBeforeTestGradeByStudentId($data['id'])}</td>
                    <td>{:$M->getLearnAfterTestGradeByTimeStudentId($data['id'])}</td>
                    <td>{:$M->getNewWordsByStudentId($data['id'])}</td>
                    <td>{:$M->getOldWordsByStudentId($data['id'])}</td>
                    <td>
                        <foreach name="M:getTestCourseTitleByStudentId($data['id'])" item="courseTitle">
                            {$courseTitle}
                            <br />
                        </foreach>
                    </td>
                </tr>
            </foreach>
        </tbody>
    </table>
    <div class="row">
        <nav>
            <Yunzhi:page totalcount="M:totalCount" />
        </nav>
    </div>
    <include file="index.js" />
</block>
