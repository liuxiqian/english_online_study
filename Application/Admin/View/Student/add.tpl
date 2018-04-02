<extend name="Base:index" />
<block name="title">
    新增学生
</block>
<block name="body">
    <form class="form-horizontal" action="{:U('save')}" method="post" name="form" ng-controller="addStudent">
        <input type="hidden" name="user_id" value="{$M->getUser()['id']}" />
        <div class="form-group row">
            <label for="username" class="col-md-2 text-right">登录名:</label>
            <div class="col-md-4">
                <input id="username" class="form-control" name="username" type="text" />
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-2 text-right">姓名:</label>
            <div class="col-md-4">
                <input id="name" class="form-control" name="name" type="text" />
            </div>
        </div>
        <div class="form-group row">
            <label for="school" class="col-md-2 text-right">家长联系方式:</label>
            <div class="col-md-4">
                <input id="school" class="form-control" name="phonenumber" type="text" ng-model="phonenumber" ng-pattern="regex" required/>
            </div>
            <p class="text-danger" ng-show="form.phonenumber.$dirty && form.phonenumber.$invalid">
                <span ng-show="form.phonenumber.$error.pattern">*请输入正确的11位手机号码</span>
            </p>
        </div>
        <div class="form-group row">
            <label for="school" class="col-md-2 text-right">学校:</label>
            <div class="col-md-4">
                <input id="school" class="form-control" name="school" type="text" />
            </div>
        </div>
        <div class="form-group row">
            <label for="username" class="col-md-2 text-right">班级:</label>
            <div class="col-md-4">
                <select id="klass" name="klass_id" class="form-control">
                    <foreach name="M:getKlasses()" item="klass">
                        <option value="{$klass['id']}">{$klass['name']}</option>
                    </foreach>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="sex" class="col-md-2 control-label">性别:</label>
            <div class="col-md-2">
                <input id="man" type="radio" name="sex" value="0" />
                <label for="man">&nbsp;男</label>&nbsp;
                <input id="woman" type="radio" name="sex" value="1" />
                <label for="woman">&nbsp;女</label>
            </div>
        </div>
        <div class="form-group">
            <label for="is_stop" class="col-md-2 control-label">卡时:</label>
            <div class="col-md-2">
                <input id="not_stop" type="radio" name="is_stop" value="0" />
                <label for="not_stop">&nbsp;不卡时</label>&nbsp;
                <input id="stop" type="radio" name="is_stop" value="1" />
                <label for="stop">&nbsp;卡时</label>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-md-2 control-label">状态:</label>
            <div class="col-md-2">
                <input id="normal" type="radio" name="status" value="0" />
                <label for="normal">&nbsp;正常</label>&nbsp;
                <input id="abnormal" type="radio" name="status" value="1" />
                <label for="abnormal">&nbsp;冻结</label>
            </div>
        </div>
        <div class="form-group row">
            <label for="number" class="col-md-2 text-right">CDK卡号:</label>
            <div class="col-md-4">
                <input id="number" name="number" ng-model="number" class="form-control" type="text" value="{$M->getCardByStudentId($studentId)['number']}" />
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-2 text-right">CDK密码:</label>
            <div class="col-md-4">
                <input type="text" id="password" ng-model="password" name="password" class="form-control" type="text" value="{$M->getCardByStudentId($studentId)['password']}" />
                <span class="text-danger" ng-show="validate">{{error}}</span>
            </div>
        </div>
        <div class="form-group row">
            <div ng-show="validate" class="col-md-10 col-md-offset-2">
                <Yunzhi:access a="validateAjax">
                    <button type="button" class="btn btn-md btn-success" ng-click="validate()" ng-disabled="disabled"><i class="fa fa-check "></i> 验证卡密</button>
                </Yunzhi:access>
            </div>
            <div ng-hide="validate" class="col-md-10 col-md-offset-2">
                <Yunzhi:access a="save">
                    <button type="submit" ng-disabled="form.phonenumber.$invalid" class="btn btn-md btn-success"><i class="fa fa-check "></i> 确认</button>
                </Yunzhi:access>
            </div>
        </div>
    </form>
    <include file="add.js" />
</block>
