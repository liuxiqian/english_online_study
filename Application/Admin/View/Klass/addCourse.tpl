<extend name="Base:index" />
<block name="title">
    新增课程
</block>
<block name="body">
    <div class="col-md-12">
        <p style="text-align: center;font-size: 24px;">{$M->getKlassNameByKlassId($klass_id)}--------课程列表</p>
    </div>
    <div class="panel-body">
    </div>
    <form class="form-horizontal" action="{:U('saveCourse',I('get.'))}" method='post' id="demoForm">
        <input type="hidden" name="klass_id" value="{$klass_id}"></input>
        <foreach name="datas" item="data">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="{$data}" name="data[]" />{$M->getNameById($data)}
                </label>
            </div>
        </foreach>
        <php>$num=count($datas)</php>
        <neq name="num" value="0">
            <div class="form-group" style="margin-top: 30px;">
                <div class="col-md-offset-2 col-md-10">
                    <Yunzhi:access a="saveCourse"><button type="submit" class="btn btn-success"><i class="fa fa-check "></i>&nbsp;确认</button></Yunzhi:access>
                </div>
            </div>
        </neq>
    </form>
</block>
