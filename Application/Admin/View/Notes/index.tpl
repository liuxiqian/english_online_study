<extend name="Base:index" />
<block name="title">
    教务笔记
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <div style="margin:0px 30px">
                <div class="row">
                    <div class="col-md-12 bg-info" style="padding-top: 5px; padding-bottom: 5px;border-radius:10px">
                        教务笔记可用于给学生发送通知消息、提示、学习资料等。编辑保存后学生可查看，若修改确认后需再次保存。
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="form-group">
                    <div class="col-md-12">
                        <form action="{:U('save')}" method="post">
                            <input type="hidden" name="id" value="{:$Notes->getId()}" />
                            <html:editor id="text" type="Ueditor" name="text">
                                {$Notes->getText() | htmlspecialchars_decode}
                            </html:editor>
                            <br />
                            <div class="text-center">
                                <button class="btn btn-md btn-success" type="submit"><i class="glyphicon glyphicon-ok"></i>&nbsp;保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</block>
<block name="pageSize">
</block>
