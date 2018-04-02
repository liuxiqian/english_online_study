<extend name="Base:index" />
<block name="title">
    编辑学生
</block>
<block name="body">
    <div class="row" ng-controller="edit">
        <form class="form-horizontal" action="{:U('save')}" method="post"  name="myForm" ng-submit="submit()">
            <input type="hidden" name="user_id" value="{$M->getUser()['id']}" />
            <input type="hidden" name="id" value="{$studentId}"></input>
            <div class="form-group row">
                <label for="username" class="col-md-2 text-right">登录名:</label>
                <div class="col-md-4">
                    <input id="username" class="form-control" name="username" type="text" value="{$M->getStudentUserNameByStudentId($studentId)}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-md-2 text-right">姓名:</label>
                <div class="col-md-4">
                    <input id="name" class="form-control" name="name" type="text" value="{$M->getStudentNameByStudentId($studentId)}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-md-2 text-right">家长联系方式:</label>
                <div class="col-md-4">
                    <input id="name" class="form-control" name="phonenumber" type="text" ng-model="phonenumber" ng-pattern="regex" required/>
                </div>
                <p class="text-danger" ng-show="myForm.phonenumber.$dirty && myForm.phonenumber.$invalid">
                    <span ng-show="myForm.phonenumber.$error.pattern">*请输入正确的11位手机号码</span>
                </p>
            </div>
            <div class="form-group row">
                <label for="school" class="col-md-2 text-right">学校:</label>
                <div class="col-md-4">
                    <input id="school" class="form-control" name="school" type="text" value="{$M->getSchoolByStudentId($studentId)}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-md-2 text-right">班级:</label>
                <div class="col-md-4">
                    <select id="klass" name="klass_id" class="form-control">
                        <foreach name="M:getKlasses()" item="klass">
                            <option value="{$klass['id']}" <eq name="M:getStudentByStudentId($studentId)['klass_id']" value="$klass['id']">selected="selected"</eq>>{$klass['name']}</option>
                        </foreach>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="sex" class="col-md-2 control-label">性别:</label>
                <div class="col-md-2">
                    <input id="man" type="radio" name="sex" value="0" <eq name="M:getStudentSexByStudentId($studentId)" value="0">checked="checked"</eq> />
                    <label for="man">&nbsp;男</label>&nbsp;
                    <input id="woman" type="radio" name="sex" value="1" <eq name="M:getStudentSexByStudentId($studentId)" value="1">checked="checked"</eq> />
                    <label for="woman">&nbsp;女</label>
                </div>
            </div>
            <div class="form-group">
                <label for="is_stop" class="col-md-2 control-label">卡时:</label>
                <div class="col-md-2">
                    <input id="not_stop" type="radio" <eq name="M:getStudentIsStopByStudentId($studentId)" value="0">checked="checked"</eq> name="is_stop" value="0" />
                    <label for="not_stop">&nbsp;不卡时</label>&nbsp;
                    <input id="stop" type="radio" name="is_stop" value="1" <eq name="M:getStudentIsStopByStudentId($studentId)" value="1">checked="checked" </eq> />
                    <label for="stop">&nbsp;卡时</label>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-2 control-label">状态:</label>
                <div class="col-md-2">
                    <input id="normal" type="radio" <eq name="M:getStudentStatusByStudentId($studentId)" value="0">checked="checked"</eq> name="status" value="0" />
                    <label for="normal">&nbsp;正常</label>&nbsp;
                    <input id="abnormal" type="radio" name="status" value="1" <eq name="M:getStudentStatusByStudentId($studentId)" value="1">checked="checked" </eq> />
                    <label for="abnormal">&nbsp;冻结</label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 col-md-offset-2">
                    <Yunzhi:access a="save">
                        <button type="submit" ng-disabled="myForm.phonenumber.$invalid" class="btn btn-md btn-success"><i class="fa fa-check "></i> 确认</button>
                    </Yunzhi:access>
                </div>
            </div>
        </form>
    </div>
    <include file="edit.js" />
</block>
