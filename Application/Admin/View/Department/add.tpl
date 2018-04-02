<extend name="Base:index" />
<block name="title">
    <?php $id = (int)$data['id']; ?>
    <eq name="id" value="0">新增区域
        <else />编辑区域</eq>
</block>
<block name="body">
    <form class="form-horizontal" action="{:U('save',I('get.'))}" method="post" name="form">
        <input type="hidden" name="id" value="{$data.id}" />
        <div class="form-group row">
            <label for="username" class="col-md-2 text-right">区域</label>
            <div class="col-md-4">
                <input name="title" value="{$data['title']}" class="form-control" type="text" required />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-8 text-center">
                <Yunzhi:access a="save">
                    <button type="submit" ng-disabled="form.password.$invalid" class="btn btn-md btn-success"><i class="fa fa-check "></i>确认</button>
                </Yunzhi:access>
            </div>
        </div>
    </form>
</block>
