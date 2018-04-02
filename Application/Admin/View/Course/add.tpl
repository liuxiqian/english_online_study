<extend name="Base:index" />
<block name="title">
    <eq name="Think.ACTION_NAME" value="add"> 新增课程
        <else />编辑课程</eq>
</block>
<block name="body">
    <div ng-controller="add">
        <form action="{:U('save', I('get.'))}" name="form" method="post">
            <div class="row">
                <div class="col-md-offset-1 col-md-11 form-group">
                    <div class="row">
                        <div class="col-md-3 input-group">
                            <input type="hidden" name="id" value="{:I('get.id')}" />
                            <span class="input-group-addon">课程名</span>
                            <input type="text" id="title" ng-minLength="1" ng-maxLength="30" name="title" value="" class="form-control" ng-model="data.title" required />
                        </div>
                        <div class="col-md-6 form-group">
                            <p class="text-danger" ng-show="form.title.$dirty && form.title.$invalid"> <span ng-show="form.title.$error.required">课程名不能为空</span></p>
                            <span class="text-danger" ng-show="form.title.$invalid && form.title.$dirty">最小长度1，最大30</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            上传单词图片
                            <img class="img-thumbnail" style="width: 300px" ng-src="{{data.attachment_url}}" ng-show="data.attachment_url" />
                            <p>(如果您看到的图片过大，那么将影响学习平台的加载速度，建议您用QQ截图等软件进行二次处理。</p>
                            <input type="hidden" class="form-control" aria-describedby="basic-addon1" name="attachment_id" value="{{data.attachment_id}}" />
                            <div class="btn btn-primary" ngf-select="upload($file)" ngf-max-files="1" ngf-max-size="1MB" accept="image/*"><i class="glyphicon glyphicon-picture"></i>&nbsp;选择图片</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-2">
                    <Yunzhi:access a="save">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;确认</button>
                    </Yunzhi:access>
                </div>
            </div>
        </form>
    </div>
    <include file="add.js" />
</block>