<extend name="Base:index" />
<block name="title">
    组测试管理
</block>
<block name="pageSize">
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="row">
                <form action="{:U('index?courseId=', I('get.'))}" method='get'>
                    <div class="col-md-3">
                        <select name="courseId" class="form-control" id="coureseId">
                            <foreach name="Course:getAllCourses()" item="course">
                                <option value="{:$course->getId()}" <?php if(I('get.courseId') == $course->getId()) : ?> selected="selected"<?php endif; ?>>{:$course->getTitle()}</option>
                            </foreach>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> &nbsp;查询</button>
                        <a href="{:U('edit', I('get.'))}" class="btn btn-info" role="button"><i class="glyphicon glyphicon-plus"></i> &nbsp;添加</a>
                    </div>
                </form>
            </div>
            <div class="panel-body">
            </div>
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>序号</th>
                    <th>百分比(%)</th>
                    <th>释义题数量</th>
                    <th>听辩题数量</th>
                    <th>听写题数量</th>
                    <th>测试时长</th>
                    <th>类型</th>
                    <th>操作</th>
                </tr>
                <foreach name="Course:getTests()" key="key" item="test">
                    <tr>
                        <td>{$key+1}</td>
                        <td>{:$test->getPercent()}</td>
                        <td>{:$test->getExplainCount()}</td>
                        <td>{:$test->getListeningCount()}</td>
                        <td>{:$test->getWriteCount()}</td>
                        <td>{:$test->getTotalMinite()}</td>
                        <td>{:$test->getTitle()}</td>
                        <td>
                        <Yunzhi:access a="edit"><a class="btn btn-md btn-primary btn-sm" href="{:U('edit?id=' . $test->getId(), I('get.'))}"><i class="fa fa-pencil"></i>&nbsp;编辑</a></Yunzhi:access>
                        <Yunzhi:access a="delete"><a a class="btn btn-md btn-danger btn-sm" href="{:U('delete?id=' . $test->getId(), I('get.'))}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></Yunzhi:access></td>
                    </tr>
                </foreach>
            </table>
        </div>
    </div>
</block>
