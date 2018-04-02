<<extend name="Base:index" />
<block name="wrapper">
    <div class="col-md-12 col-sm-6">
        <div class="panel-body">
        </div>
        <form action="{:U()}" method="get">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group custom-search-form">
                        <div class="form-group input-group">
                            <span class="input-group-addon">开始日期</span>
                            <input class="form-control datetimepicker" name="beginDate" type="text" value="{:I('get.beginDate')}" data-date-format="yyyy-mm-dd" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group custom-search-form">
                        <div class="form-group input-group">
                            <span class="input-group-addon">截止日期</span>
                            <input class="form-control datetimepicker" name="endDate" type="text" value="{:I('get.endDate')}" data-date-format="yyyy-mm-dd" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-search"></span>&nbsp;查看</button>
            </div>
        </form>
        <div class="panel-body">
        </div>
        <table class="table table-bordered table-striped table-hover table-condensed">
            <thead>
                <th class="info">日期</th>
                <th class="info">学习新词</th>
                <th class="info">复习</th>
                <th class="info">测试（正确率）</th>
            </thead>
            <tbody>
                <foreach name="datas" item="data">
                <tr>
                  <td>{:date("Y-m-d", $data->getTime())}</td>
                  <td>{:$data->getNewWordsCount()}</td>
                  <td>{:$data->getOldWordsCount()}</td>
                  <td>{:$data->getScore()}</td>
                </tr>
                </foreach>
            </tbody>
        </table>
    </div>
    <include file="index.js" />
</block>
