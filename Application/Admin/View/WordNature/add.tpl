<extend name="Base:index" />
<block name="title">
    {$title}
</block>
<block name="body">
    <form class="form-horizontal" action="{:U('save',I('get.'))}" method='post' id="demoForm">
        <input name="id" value="{$data['id']}" type="hidden"></input>
        <div class="form-group">
            <label for="title" class="col-md-2 control-label">名称</label>
            <div class="col-md-4">
                <input class="form-control" name="name" value="{$data['name']}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check "></i>&nbsp;确认添加</button>
            </div>
        </div>
    </form>
</block>

