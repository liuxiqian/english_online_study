<extend name="Base:index" />
<block name="wrapper">
    <div class="col-md-12 col-sm-6" ng-app="analysis">
        <div class="panel-body">
        </div>
        <div class="row">
            <form action="{:U('index?')}" method="get">
                <div class="col-md-4">
                    <div class="form-group input-group">
                        <span class="input-group-addon">选择统计项</span>
                        <select name="type" class="form-control">
                            <php>$type=I('get.type'); if($type=='') $type=time;</php>
                            <option value="time" <eq name="type" value="time">selected="selected"</eq>>每天学习时长</option>
                            <option value="amount" <eq name="type" value="amount">selected="selected"</eq>> 每天词汇量</option>
                            <option value="grade" <eq name="type" value="grade">selected="selected"</eq>>学习成绩</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3" data-date-format="dd-mm-yyyy">
                    <div class="form-group input-group">
                        <span class="input-group-addon">选择日期</span>
                        <input type="text" class="form-control datetimepicker" id="datetimepicker" data-date-format="yyyy-mm" value="{:I('get.time') ? I('get.time') : date('Y-m')}" name="time" />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-search"></span>&nbsp;查看</button>
            </form>
        </div>
        <eq name="type" value="time">
            <h4 style="text-align: center;"><strong>每天学习时长</strong></h4>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        本月{:date('Y-m',$time)}
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" ng-controller="LineCtrlTime">
                        <div class="flot-chart">
                            <canvas id="canvasTime" class="chart chart-line" chart-data="data" chart-labels="labels" chart-series="series">
                            </canvas>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </eq>
        <eq name="type" value="amount">
            <h4 style="text-align: center;"><strong>每天词汇量</strong></h4>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        本月{:date('Y-m',$time)}
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="flot-chart" ng-controller="LineCtrlAmount">
                            <canvas id="canvasTime" class="chart chart-line" chart-data="data" chart-labels="labels" chart-series="series">
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </eq>
        <eq name="type" value="grade">
            <h4 style="text-align: center;"><strong>学习成绩</strong></h4>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        本月{:date('Y-m',$time)}
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" ng-controller="BarCtrlGrade">
                        <div class="flot-chart">
                            <canvas id="canvasTime" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-series="series.title" chart-colors="series.colors">
                        </div>
                        <div class="row text-center">
                            <div class="col-md-6 col-md-push-4">
                                <div ng-repeat="title in series.title" class="serie" style="background-color: {{series.colors[$index]}};">{{title}}</div>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </eq>
        <div class="row">
            <ul class="pager">
                <div class="col-md-2 col-md-offset-2">
                    <li><a href="{:U('index?time='.$DayStudyTime->getPreMonthDate(), I('get.'))}">上一月</a></li>
                </div>
                <div class="col-md-2 col-md-offset-4">
                    <li><a href="{:U('index?time='.$DayStudyTime->getNextMonthDate(), I('get.'))}">下一月</a></li>
                </div>
            </ul>
        </div>
        <include file="index.js" />
        <include file="index.css" />
    </div>
</block>
<block name="footJs">
    <script src="__ROOT__/node_modules/chart.js/dist/Chart.min.js"></script>
    <script src="__ROOT__/node_modules/angular-chart.js/dist/angular-chart.min.js"></script>
</block>
