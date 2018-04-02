<extend name="Base:index" />
<block name="title">
    进度详情
</block>
<block name="body">
    <div ng-controller="schedetail">
        <div class="col-md-12 text-center">
            <h3>{:$detailModel->getStudent()->getKlass()->getName()}----{:$detailModel->getStudent()->getName()}</h3>
        </div>
        <hr />
        <div class="panel-body"></div>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th rowspan="2">课程</th>
                    <th rowspan="2">学习次数</th>
                    <th rowspan="2">首次学习</a></th>
                    <th rowspan="2">末次学习</a></th>
                    <th rowspan="2">上次用时（分）</th>
                    <th rowspan="2">累计用时（分）</th>
                    <th rowspan="2">新学(个)</th>
                    <th rowspan="2">复习(个次)</th>
                    <th rowspan="2">总计(个次）</th>
                    <th rowspan="2">剩余词汇</th>
                    <th rowspan="2">词汇总数</th>
                    <th rowspan="2">进度</th>
                    <th rowspan="2">学习记录</th>
                    <th rowspan="2">测试记录</th>
                </tr>
            </thead>
            <tbody>
                <foreach name="detailModel:getSchedules()" item="schedule">
                    <tr>
                        <td>{$schedule->getCourseTitle()}</td>
                        <td>{$schedule->getStudyCount()}</td>
                        <td>{:date('Y-m-d H:i:s', $schedule->getFirstStudyTime())}</td>
                        <td>{:date('Y-m-d H:i:s', $schedule->getLastStudyTime())}</td>
                        <td>{$schedule->getLastTotalMinutes()}</td>
                        <td>{$schedule->getTotalMinutes()}</td>
                        <td>{$schedule->getNewStudyWordCount()}</td>
                        <td>{$schedule->getOldStudyWordCount()}</td>
                        <td>{$schedule->getTotalStudyWordCount()}</td>
                        <td>{$schedule->getRemainWordCount()}</td>
                        <td>{$schedule->getCourseTotalWordCount()}</td>
                        <td>{$schedule->getStudyProcess()}%</td>
                        <td><a href="{:U('studyrecord?course_id=' . $schedule->getCourseId(),  I('get.'))}">查看</a></td>
                        <td><a href="{:U('testrecord?course_id=' . $schedule->getCourseId(), I('get.'))}">查看</a></td>
                    </tr>
                </foreach>
            </tbody>
        </table>
        <div class="row">
            <nav>
                <Yunzhi:page />
            </nav>
        </div>
    </div>
</block>