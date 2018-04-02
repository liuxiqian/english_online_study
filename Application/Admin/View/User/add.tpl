<extend name="Base:index" />
<block name="title">
    <eq name="Think.ACTION_NAME" value="add"> 添加用户
        <else />编辑用户</eq>
</block>
<block name="body">
    <div class="row-fluid" ng-controller="userAdd">
        <div class="col-md-12">
            <div class="panel-body">
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" name="form" action="{:U('save',I('get.'))}" method='post'>
                        <input type="hidden" name="id" value="{:$M->user['id']}" />
                        <input type="hidden" name="department_post_id" value="{{user.post.id}}" />
                        <eq name="M:checkIsEdit()" value="1">
                            <div class="form-group">
                                <label for="username" class="col-md-2 control-label">用户名</label>
                                <span class="">{{user.username}}</span>
                            </div>
                            <else />
                            <input name="password" type="hidden"></input>
                            <div class="form-group">
                                <label for="username" class="col-md-2 control-label">用户名</label>
                                <div class="col-md-4">
                                    <input name="username" class="form-control"  ng-blur="validate()" ng-model="user.username" required/>
                                    <p class="text-danger" ng-show="form.username.$dirty && form.username.$invalid"> 
                                    <span ng-show="form.username.$error.required">用户名不能为空</span></p>
                                    <p><span class="text-danger" ng-show="validate">{{error}}</span>
                                    </p>
                                </div>
<!--                                 <div ng-show="judge" class="col-md-1">
                                    <span class="fa fa-check true success"></span>
                                    <span ng-hide="judge" class="glyphicon glyphicon-remove red"></span>
                                </div> -->
                            </div>
                        </eq>
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">姓名</label>
                            <div class="col-md-4">
                                <input name="name" class="form-control" ng-model="user.name" ng-disabled="{{edit}}" required/>
                                <p class="text-danger" ng-show="form.name.$dirty && form.name.$invalid"> <span ng-show="form.name.$error.required">姓名不能为空</span></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">区域</label>
                            <div class="col-md-4">
                                <select class="form-control" name="department_id" ng-model="user.department" ng-options="option.title for option in departments track by option.id">
                                    <option value="{{option.id}}">{{option.title}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">岗位</label>
                            <div class="col-md-4">
                                <select class="form-control" name="post_id" ng-model="user.post" ng-options="option.name for option in user.department.allowedPosts track by option.id">
                                    <option value="{{option.id}}">{{option.name}}</option>                
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phonenumber" class="col-md-2 control-label">手机号</label>
                            <div class="col-md-4">
                                <input id="phonenumber" name="phonenumber" ng-model="user.phonenumber" class="form-control" ng-pattern="regex" required/>
                                <p class="text-danger" ng-show="form.phonenumber.$dirty && form.phonenumber.$invalid"> 请输入正确的11位手机号码</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-2 control-label">邮箱</label>
                            <div class="col-md-4">
                                <input name="email" class="form-control" ng-model="user.email" type="email" required/>
                                <p class="text-danger" ng-show="form.email.$dirty && form.email.$invalid"> <span ng-show="form.email.$error.required">邮箱不能为空</span></p>
                                <span class="text-danger" ng-show="form.email.$dirty && form.email.$invalid">
                                <span ng-show="form.email.$error.email">*邮箱格式错误</span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <Yunzhi:access a="save">
                                    <button type="submit" ng-disabled="form.phonenumber.$invalid || form.email.$invalid" class="btn btn-md btn-success">
                                        <i class="fa fa-check"></i>&nbsp;确认</button>
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
