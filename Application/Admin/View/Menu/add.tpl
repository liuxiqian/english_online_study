<extend name="Base:index" />
<block name="body">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    添加
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{:U('save',I('get.'))}" method='post' id="demoForm">
                        <div style="display:none">
                            <input name="edit" value="{$data.edit}">
                            <input name="id" value="{$data.id}">
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-2 control-label">标题</label>
                            <div class="col-md-4">
                                <input class="form-control" name="title" value="{$data.title}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subhead" class="col-md-2 control-label">副标题</label>
                            <div class="col-md-4">
                                <input class="form-control" id="subhead" name="subhead" value="{$data.subhead}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent_id" class="col-md-2 control-label">上级菜单</label>
                            <div class="col-md-4">
                                <select class="selectpicker form-control select2" name="parent_id">
                                    <option value="0">根菜单</option>
                                    <foreach name="menuList" item="menu">
                                        <option value="{$menu.id}" <if condition="$menu['id'] eq $data['parent_id']"> selected="selected"</if> >
                                            <php>
                                                for($level = 0; $level
                                                < $menu[ '_level']; $level++) echo "|--"; </php>
                                                    {$menu.title}</option>
                                    </foreach>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="icon" class="col-md-2 control-label">小图标</label>
                            <div class="col-md-4">
                                <input class="form-control" id="icon" name="icon" value="{$data.icon}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="module" class="col-md-2 control-label ">模块名</label>
                            <div class="col-md-4">
                                <input class="form-control" name="module" value="{:($data['module'] !== null) ? $data['module'] : I('get.module')}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="controller" class="col-md-2 control-label ">控制器名</label>
                            <div class="col-md-4">
                                <input class="form-control" name="controller" value="{:(isset($data['controller']) ? $data['controller'] : I('get.controller'))}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="action" class="col-md-2 control-label">方法名</label>
                            <div class="col-md-4">
                                <input class="form-control" name="action" value="{:($data['action'] !== null) ? $data['action'] : I('get.action')}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order" class="col-md-2 control-label">排序</label>
                            <div class="col-md-4">
                                <input class="form-control" id="order" name="order" value="{$data.order}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="show" class="col-md-2 control-label">是否显示</label>
                            <div class="col-md-4">
                                <div class="col-md-6 form-group">
                                    <select class="selectpicker form-control" name="show">
                                        <option value="0">否</option>
                                        <option value="1" <neq name="data.show" value="0">selected="selected"</neq>>是</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-md-2 control-label">是否开发模式</label>
                            <div class="col-md-4">
                                <div class="col-md-6 form-group">
                                    <select class="selectpicker form-control" name="development">
                                        <option value="0">否</option>
                                         <option value="1" <neq name="data.development" value="0">selected="selected"</neq>>是</option>
                                    </select>
                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            岗位权限<foreach name="M:getMenuPostListsByMenuId($data['id'])" item="menuPostList">
                                <input id="menupost{$menuPostList['id']}" type="checkbox" name="post[]" value="{$menuPostList['id']}" <eq name="menuPostList['is_permission']" value="1">checked="checked"</eq>/>
                                <label for="menupost{$menuPostList['id']}">{$menuPostList['name']}</label>
                            </foreach>
                        </div>
                        <div class="form-group">
                            <label for="action" class="col-md-2 control-label">开发日期</label>
                            <div class="col-md-4">
                                <input class="form-control" name="dev_time" value="{$data.dev_time }">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="action" class="col-md-2 control-label">开发分支</label>
                            <div class="col-md-4">
                                <input class="form-control" name="parameter" value="{$data.parameter}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="action" class="col-md-2 control-label">开发工程师</label>
                            <div class="col-md-4">
                                <input class="form-control" name="dev_user" value="{$data.dev_user}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="action" class="col-md-2 control-label">是否已完成</label>
                            <div class="col-md-4">
                            <select name="is_done">
                                <option value="0">否</option>
                                <option value="1" <eq name="data['is_done']" value="1">selected="selected"</eq>>是</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="remarks" class="col-md-2 control-label">备注</label>
                            <div class="col-md-4">
                                <textarea class="form-control" rows="3" name="remarks">{$data.remark}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-md btn-success"><i class="fa fa-check "></i> 确认</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <include file="addjs" />
    </div>
</block>
