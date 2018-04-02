<extend name="Base:index" />
<block name="title">
    新增课程
</block>
<block name="body">
    <div ng-controller="articleIndex">
        <div class="row">
            <div class="col-md-12">
                <p style="text-align: center;font-size: 24px;">当前班级：{$Klass->getName()}</p>
            </div>
            <div ng-show="info" class="alert alert-success" role="alert" ng-bind="info"></div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>标题</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="article in articles">
                        <td>
                            <Yunzhi:access a="articleSaveAjax">
                                <input type="checkbox" ng-change="save(article)" id="article{{article.id}}" ng-model="article.isKlassOwned" />
                            </Yunzhi:access>
                            <label for="article{{article.id}}">{{ $index + 1}}</label>
                        </td>
                        <td>
                            <label for="article{{article.id}}">{{article.title}}</label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <nav>
                <Yunzhi:page />
            </nav>
        </div>
    </div>
    <include file="articleIndex.js" />
</block>
