<extend name="Base:index" />
<block name="title">
有效期管理
</block>
<block name="body">
    <div class="row">
    <form name="form" action="{:U('save', I('get.'))}" method="post">
        <div class="col-md-11 col-md-push-1" ng-app="Course" ng-controller="index">
 
        <div class="row">
            <div class="col-md-3 form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">注册日期</span>
                    <input type="text" id="word" name="word" value="" class="form-control"  ng-model="word" aria-describedby="basic-addon1"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">截止日期</span>
                    <input type="text" id="word" name="word" value="" class="form-control"  ng-model="word" aria-describedby="basic-addon1"/>
                </div>
            </div>
        </div>

            <div>
                <button type="submit" class="btn btn-success">保存</button>
            </div>

        </div>
        </form>
    </div>
</block>
