<extend name="Base:index" />
<block name="footJs">
    <!--webuploader-->
    <js href="__ROOT__/lib/webuploader/webuploader.min.js" />
    <js href="__ROOT__/yunzhi.php/Webuploader/config.html" />

    <!--ng-file-upload-->
    <js href="__ROOT__/lib/ngfileupload/ng-file-upload.min.js" />
</block>
<block name="wrapper">
    <div class="row-fluid" ng-app="student" ng-controller="add">
        <div class="col-md-12">
            <form class="form-horizontal" name="form" ng-submit="submit()">
                <input type="hidden" name="id" value="{$Student->getId()}" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4 text-right">
                                    <label for="job_title1">疲劳指数：</label>
                                </div>
                                <div class="col-md-6">
                                    <select ng-model="student.indexOfFatigueId" name="index_of_fatigue_id" class="form-control">
                                        <foreach name="Student:getIndexOfFatigue():getAllLists()" item="indexOfFatigue">
                                            <option value="{$indexOfFatigue->getId()}">{:$indexOfFatigue->getTitle()}</option>
                                        </foreach>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4 text-right">
                                    <label>&nbsp;我要跟谁比：</label>
                                </div>
                                <div class="col-md-8">
                                    <input id="klass" type="radio" ng-model="student.compare" name="compare" value="0" />
                                    <label for="klass">&nbsp;本班同学</label>&nbsp;
                                    <input id="all" type="radio" ng-model="student.compare" name="compare" value="1" />
                                    <label for="all">&nbsp;所有人</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4 text-right">
                                    <label for="job_title00">&nbsp;愿意成为学习榜样：</label>
                                </div>
                                <div class="col-md-8">
                                    <input id="job_title00" type="radio" ng-model="student.isHero" name="is_hero" value="0" />
                                    <label for="job_title00">&nbsp;愿意</label>&nbsp;
                                    <input id="job_title01" type="radio" name="is_hero" value="1" ng-model="student.isHero" />
                                    <label for="job_title01">&nbsp;不愿意</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="form-group">
                           <a href="javascript:void(0);" ngf-select="upload($file)" ngf-max-files="1" ngf-max-size="1MB" accept="image/*"><img style="max-height: 150px;"ng-src="{{student.imgUrl}}" class="img-responsive" /></a>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <tbody>
                        <tr>
                            <td class="success" width="30%">
                                账号
                            </td>
                            <td width="70%">
                                <div class="col-md-3 col-sm-6">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6">{:$Student->getUsername()}</div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success" width="30%">
                                微信二维码
                            </td>
                            <td width="70%">
                                <img class="img-thumbnail qrcode" src="{:$Student->getQrcode()}" />
                            </td>
                        </tr>
                        <tr>
                            <td class="success" width="30%">
                                姓名
                            </td>
                            <td width="70%">
                                <div class="col-md-3 col-sm-6">
                                    <input type="text" name="name" class="form-control" ng-model="student.name" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success" width="30%">
                                性别
                            </td>
                            <td width="70%">
                                <div class="col-md-3 col-sm-6">
                                    <select class="selectpicker form-control" name="sex" ng-model="student.sex">
                                        <option value="0">男</option>
                                        <option value="1">女</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success" width="30%">
                                学校
                            </td>
                            <td width="70%">
                                <div class="col-md-3 col-sm-6">
                                <input type="text" name="school" class="form-control" ng-model="student.school" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success" width="30%">
                                班级
                            </td>
                            <td width="70%">
                                <div class="col-md-3 col-sm-6">
                                {:$Student->getKlass()->getName()}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success" width="30%">
                                教师姓名
                            </td>
                            <td width="70%">
                                <div class="col-md-3 col-sm-6">
                                    {:$Student->getKlass()->getTeacher()->getName()}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success" width="30%">
                                教师邮箱
                            </td>
                            <td width="70%">
                                <div class="col-md-3 col-sm-6">
                                    {:$Student->getKlass()->getTeacher()->getEmail()}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success" width="30%">
                                教师联系电话
                            </td>
                            <td width="70%">
                                <div class="col-md-3 col-sm-6">
                                    {:$Student->getKlass()->getTeacher()->getPhonenumber()}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success">
                                <label for="userpassword">原密码</label>
                            </td>
                            <td>
                                <div class="col-md-3 col-sm-6">
                                    <input type="password" class="form-control" name="password" ng-model="student.password" placeholder="请输入原密码" value="{:$Student->getPassword()}" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success">
                                <label for="userpassword">新密码</label>
                            </td>
                            <td>
                                <div class="col-md-3 col-sm-6">
                                    <input type="password" ng-minlength="4" ng-maxlength="16" class="form-control" name="newpassword" ng-model="student.newPassword" placeholder="请输入新密码" />
                                </div>
                                <div class="col-sm-6" ng-show="form.newpassword.$dirty && !form.newpassword.$valid">
                                    <code>密码长度介于4至16位之间,为数字及英文字母的组合</code>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="success">
                                <label>确认密码</label>
                            </td>
                            <td>
                                <div class="col-md-3 col-sm-6">
                                    <input type="password" class="form-control" name="repassword" ng-model="repassword" placeholder="再次输入新密码" />
                                    <span class="text-danger" ng-show="different"> 再次输入新密码</span>
                                </div>
                                <div class="col-md-3 col-sm-6" ng-show="form.repassword.$dirty">
                                    <code><span ng-bind="hasError"></span></code>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <div class="alert alert-success" role="alert" ng-show="error" ng-bind="error"></div>
                    <button type="submit" class="btn btn-success" ng-disabled="submitDisable"><span class="glyphicon glyphicon-ok"></span>&nbsp;保存</button>
                </div>
            </form>
        </div>
    </div>
    <include file="index.js" />
    <include file="index.css" />
</block>
