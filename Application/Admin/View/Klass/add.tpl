<extend name="Base:index" />
<block name="title">
    <?php $id = (int)$data['id']; ?>
    <eq name="id" value="0">添加班级
        <else />编辑班级</eq>
</block>
<block name="body">
    <form class="form-horizontal" action="{:U('save',I('get.'))}" method='post' id="demoForm">
        <input name="id" value="{$data['id']}" type="hidden"></input>
        <input name="user_id" value="{$data['user_id']}" type="hidden"></input>
        <div class="form-group">
            <label for="title" class="col-md-2 control-label">名称</label>
            <div class="col-md-4">
                <input class="form-control" name="name" value="{$data['name']}">
            </div>
        </div>
        <div class="form-group">
            <label for="user_id" class="col-md-2 control-label">教师</label>
            <div class="col-md-4">
                <select name="user_id" id="user_id">
                    <foreach name="currentTeacher:getAllowedTeachers()" item="teacher">
                        <option <eq name="teacher:getId()" value="$data['user_id']">selected="selected"</eq> value="{$teacher->getId()}">{$teacher->getName()}</option>
                    </foreach>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <Yunzhi:access a="save">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check "></i>&nbsp;确认</button>
                </Yunzhi:access>
            </div>
        </div>
    </form>
</block>
