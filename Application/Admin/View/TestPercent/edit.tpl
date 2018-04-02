<extend name="Base:index" />
<block name="title">
    <?php $id = (int)$Test->getId(); ?>
    <eq name="id" value="0">添加组测试
        <else />编辑组测试</eq>
</block>
<block name="body">
    <div ng-controller="testPercent">
        <form action="{:U('save', I('get.'))}" name="form" method="post">
            <div class="row">
                <div class="col-md-offset-1 col-md-11 form-group">
                    <div class="row">
                        <div class="col-md-3 input-group">
                            <input type="hidden" name="id" value="{:I('get.id')}" />
                            <input type="hidden" name="course_id" value="{:I('get.courseId')}" />
                            <span class="input-group-addon">测试百分比(%)</span>
                            <input class="form-control" type="number" name="percent" id="percent" min="0" max="100" ng-model="percent" required/>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-danger" ng-show="form.percent.$error.required">测试百分比不能为空</span>
                            <span class="text-danger" ng-show="form.percent.$error.number">*非法的数字</span>
                            <span class="text-danger" ng-show="form.percent.$error.min">*请填写1-100内的数字</span>
                            <span class="text-danger" ng-show="form.percent.$error.max">*请填写1-100内的数字</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 input-group">
                            <span class="input-group-addon">释义题数量</span>
                            <input class="form-control" type="number" name="explain_count" id="explain_count" min="0" max="100" ng-model="explainCount" required/>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-danger" ng-show="form.explain_count.$error.required">测试百分比不能为空</span>
                            <span class="text-danger" ng-show="form.explain_count.$error.number">*非法的数字</span>
                            <span class="text-danger" ng-show="form.explain_count.$error.min">*请填写1-100内的数字</span>
                            <span class="text-danger" ng-show="form.explain_count.$error.max">*请填写1-100内的数字</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 input-group">
                            <span class="input-group-addon">听辩题数量</span>
                            <input class="form-control" type="number" name="listening_count" id="listening_count" min="0" max="100" ng-model="listeningCount" required/>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-danger" ng-show="form.listening_count.$error.required">测试百分比不能为空</span>
                            <span class="text-danger" ng-show="form.listening_count.$error.number">*非法的数字</span>
                            <span class="text-danger" ng-show="form.listening_count.$error.min">*请填写1-100内的数字</span>
                            <span class="text-danger" ng-show="form.listening_count.$error.max">*请填写1-100内的数字</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 input-group">
                            <span class="input-group-addon">听写题数量</span>
                            <input class="form-control" type="number" name="write_count" id="write_count" min="0" max="100" ng-model="writeCount" required/>
                        </div>
                        <div class="col-md-6 form-group">
                            <span class="text-danger" ng-show="form.write_count.$error.required">测试百分比不能为空</span>
                            <span class="text-danger" ng-show="form.write_count.$error.number">*非法的数字</span>
                            <span class="text-danger" ng-show="form.write_count.$error.min">*请填写1-100内的数字</span>
                            <span class="text-danger" ng-show="form.write_count.$error.max">*请填写1-100内的数字</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 input-group">
                            <span class="input-group-addon">测试时长(分)</span>
                            <input class="form-control" type="number" name="total_minite" id="total_minite" min="0" max="300" ng-model="totalMinite" required/>
                        </div>
                    </div>
                    <br />
                    <!-- 测试类型动态获取 -->
                    <div class="row">
                        <div class="col-md-3 input-group">
                            <span class="input-group-addon">测试类型</span>
                            <select name="type" class="form-control">
                                <foreach name="Test:getTitleList()" item="typeList" key="key">
                                    <option value="{:$key}" <eq name="Test:getType()" value="$key">selected="selected"</eq>>{:$typeList}</option>
                                </foreach>
                            </select>
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
    <include file="edit.js" />
</block>
