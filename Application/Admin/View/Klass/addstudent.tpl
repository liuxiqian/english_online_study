<extend name="Base:index" />
<block name="title">
    新增学生
</block>
<block name="body">
    <div class="col-md-12">
        <p style="text-align: center;font-size: 24px;">{$M->getKlassNameByKlassId($klass_id)}--------添加学生列表</p>
    </div>
    <div class="panel-body">
    </div>
    <form class="form-horizontal" action="{:U('saveStudent',I('get.'))}" method='post' id="demoForm">
        <input name="klass_id" type="hidden" value="{$klass_id}"></input>
        <foreach name="datas" item="data">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="{$data['id']}" name="data[id][]" />{$data['username']}（{$data['name']}）
                </label>
            </div>
        </foreach>
        <php>$num=count($datas)</php>
        <neq name="num" value="0">
            <div class="form-group" style="margin-top: 30px;">
                <div class="col-md-offset-2 col-md-10">
                    <Yunzhi:access a="saveStudent"><button type="submit" class="btn btn-success"><i class="fa fa-check "></i>&nbsp;确认</button></Yunzhi:access>
                </div>
            </div>
        </neq>
    </form>
</block>
