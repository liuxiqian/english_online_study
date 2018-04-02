<extend name="Base:index" />
<block name="title">
    生成卡密
</block>
<block name="body">
    <div class="row" ng-controller="cardCtrl">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" action="{:U('writeExcel')}" method='post' name="myForm">
                        <div class="form-group">
                            <!-- {{myForm}} -->
                            <label for="num" class="col-sm-2 control-label">生成个数</label>
                            <div class="col-sm-4" class="form-control">
                                <input class="form-control" type="number" name="num" id="num" min="1" max="100" ng-model="num" required />
                                <span class="text-danger" ng-show="myForm.num.$error.required">*生成个数必填</span>
                                <span class="text-danger" ng-show="myForm.num.$error.number">*非法的数字</span>
                                <span class="text-danger" ng-show="myForm.num.$error.min">*请填写1-100内的数字</span>
                                <span class="text-danger" ng-show="myForm.num.$error.max">*请填写1-100内的数字</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deadline" class="col-sm-2 control-label">截止日期</label>
                            <div class="col-md-4">
                                <input name="deadline" id="deadline" value="{$cycle['starttime']}" class="form-control datetimepicker" ng-model="starttime" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="effective_days" class="col-sm-2 control-label">有效天数</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="number" name="effective_days" id="effective_days" min="1" max="1000" ng-model="effective_days" required />
                                <span class="text-danger" ng-show="myForm.effective_days.$error.required">*有效天数必填</span>
                                <span class="text-danger" ng-show="myForm.effective_days.$error.number">*非法的数字</span>
                                <span class="text-danger" ng-show="myForm.effective_days.$error.min">*请填写1-1000内的数字</span>
                                <span class="text-danger" ng-show="myForm.effective_days.$error.max">*请填写1-1000内的数字</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="batch" class="col-sm-2 control-label">批次</label>
                            <div class="col-md-4">
                                <label class="control-label" id="batch">{:$M->getBatch()}</label>
                                <input hidden="hidden" name="batch" value="{:$M->getBatch()}">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="phoneCode" class="col-sm-2 control-label">验证码</label>
                            <div class="col-md-4 col-sm-4">
                                <input ng-change="verify(code)" id="phoneCode" name="phoneCode" id="phoneCode" ng-model="code" class="form-control" name="title" ng-value="code" required />
                                <span class="text-danger" ng-show="myForm.phoneCode.$error.required">*手机验证码必填</span>
                                <span class="text-danger" ng-show="myForm.phoneCode.$error.number">*非法的数字</span>
                                <span class="text-danger" ng-show="update">{{err}}</span>
                            </div>
                            <div class="col-md-4">
                                <button ng-click="setAuthCode()" ng-model="disabled" class="btn btn-primary" ng-disabled="disabled">获取验证码{{mum}}</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                <span>验证码将发送给{:$rePhone}</span>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4" ng-disabled="expression">
                                <Yunzhi:access a="writeExcel">
                                    <button ng-disabled="myForm.$invalid" type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> 生成</button>
                                </Yunzhi:access>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <include file="add.js" />
</block>
