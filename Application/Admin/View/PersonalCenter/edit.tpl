<extend name="Base:index" />
<block name="title">
    个人中心
</block>
<block name="body">
    <div class="row" ng-controller="edit">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" action="{:U('save')}" method="post" name="myForm" ng-submit="submit()">
                                <input type="hidden" name="id" value="{$user.id}" />
                                <div class="form-group">
                                    <label for="username" class="col-md-2 text-right">登录名</label>
                                    <div class="col-md-4">
                                        <input class="form-control" value="{$user.username}" disabled="disabled"></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-md-2 text-right">姓名</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="name" value="{$user.name}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phonenumber" class="col-md-2 text-right">手机号</label>
                                    <div class="col-md-4">
                                        <input class="form-control" name="phonenumber" ng-model="phonenumber" ng-pattern="regex" required/>
                                    </div>
                                    <p class="text-danger" ng-show="myForm.phonenumber.$dirty && myForm.phonenumber.$invalid">
                                        <span ng-show="myForm.phonenumber.$error.pattern">*请输入正确的11位手机号码</span>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-md-2 text-right">QQ邮箱</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="email" name="email" ng-model="email" type="email" required/>
                                    </div>
                                    <p class="text-danger" ng-show="myForm.email.$dirty && myForm.email.$invalid"> <span ng-show="myForm.email.$error.required">邮箱不能为空</span></p>
                                    <span class="text-danger" ng-show="myForm.email.$dirty && myForm.email.$invalid">
                                        <span ng-show="myForm.email.$error.email">*邮箱格式错误</span>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-md-2 text-right">原密码</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="password" ng-model="password" id="password" name="password" />
                                    </div>
                                    <span class="text-danger" ng-show="myForm.password.$error.required && myForm.password.$error.$dirty">*请输入原密码</span>
                                </div>
                                <div class="form-group">
                                    <label for="newpassword" class="col-md-2 text-right">新密码</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="password" ng-model="newpassword" ng-minlength="6" ng-maxlength="20" name="newpassword" />
                                    </div>
                                    <span class="text-danger" ng-show="myForm.newpassword.$invalid && myForm.newpassword.$dirty"><code>密码长度不小于6位，不大于20位</code></span>
                                </div>
                                <div class="form-group">
                                    <label for="repassword" class="col-md-2 text-right">确认密码</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="password" ng-model="repassword" name="repassword" />
                                    </div>
                                    <span class="text-danger" ng-show="myForm.repassword.$dirty"></span>
                                    <code>{{hasError}}</code>
                                    <span class="text-danger" ng-show="different"> 再次输入新密码</span>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-7 text-center">
                                        <Yunzhi:access a="save">
                                            <button type="submit" ng-disabled="myForm.phonenumber.$invalid || myForm.email.$invalid" class="btn btn-md btn-success"><i class="fa fa-check "></i> 确认</button>
                                        </Yunzhi:access>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <include file="edit.js" />
</block>
