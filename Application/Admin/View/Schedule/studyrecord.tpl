<extend name="Base:index" />
<block name="title">
    学习记录
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>{$Student->getKlass()->getName()} -- {$Student->getName()}</h3>
                </div>
                <hr />
                <div class="col-md-12">
                    <form action="{:U('?course_id=&begin_time=&end_time=', I('get.'))}" method="get">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">课程</span>
                                        <select name="course_id" class="form-control">
                                            <option value="0">全部</option>
                                            <php>$courseId = (int)I('get.course_id');</php>
                                            <foreach name="Student:getAllCourses()" item="course">
                                                <option value="{$course->getId()}" <eq name="course:getId()" value="$courseId">selected="selected"</eq>>{$course->getTitle()}</option>
                                                }
                                            </foreach>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group custom-search-form">
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">开始日期</span>
                                            <input class="form-control datetimepicker" name="begin_time" type="text" value="{:date('Y-m-d', $beginTime)}" placeholder="" data-date-format="yyyy-mm-dd" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group custom-search-form">
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">结束日期</span>
                                            <input class="form-control datetimepicker" name="end_time" type="text" value="{:date('Y-m-d', $endTime)}" placeholder="" data-date-format="yyyy-mm-dd" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group custom-search-form">
                                        <span class="input-group-btn">
                                            <button class="btn btn-md btn-default" type="submit">
                                                <i class="glyphicon glyphicon-search"></i>&nbsp;查询
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>课程名称</th>
                            <th>学习日期</th>
                            <th>新学</th>
                            <th>复习</th>
                            <th>学习时间</th>
                            <th>有效时长(分钟)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <foreach name="dayStudyTimes" item="dayStudyTime">
                            <foreach name="courses" item="Course">
                                <foreach name="dayStudyTime:getStudyRecordListsByCourse($Course)" item="record">
                                    <tr>
                                        <td>{$Course->getTitle()}</td>
                                        <td>{:date('Y-m-d', $dayStudyTime->getTime())}</td>
                                        <td>{$record->getNewStudyWordsCount()}</td>
                                        <td>{$record->getOldStudyWordsCount()}</td>
                                        <td>{:date('H:i:s', $record->getTime())}&nbsp;-&nbsp;{:date('H:i:s', $record->getEndtime())}</td>
                                        <td>{$record->getEffectiveMinutes()}</td>
                                    </tr>
                                </foreach>
                            </foreach>
                        </foreach>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <nav>
                    <Yunzhi:page totalcount="M:totalCount" />
                </nav>
            </div>
        </div>
    </div>
    <include file="studyrecord.js" />
</block>
