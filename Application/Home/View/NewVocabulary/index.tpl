<extend name="Base:index" />
<block name="wrapper">
    <div ng-app="mengyunzhi" class="col-md-12 col-sm-12" ng-controller="vocabulary">
        <div class="row-fluid">
            <div class="col-md-offset-9 text-right">
                <form class="form-search" action="{:U('index?keywords=', I('get.'))}" method="get">
                    <div class="col-md-8">
                        <input class="form-control" name="keywords" type="text" value="{:I('get.keywords')}" placeholder="单词...">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="button btn btn-primary"><i class="glyphicon glyphicon-search"></i> 查找</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <include file="panel" />
            </div>
        </div>
        <nav>
            <Yunzhi:page totalcount="totalCount" />
        </nav>
        <div id="alert" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display:none;margin-top: 100px; padding-right: 15px;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">您要删除该生词吗？</h4>
                    </div>
                    <div class="modal-body">
                        <button class="btn btn-sm btn-primary" ng-click='cancel()'><i class="glyphicon glyphicon-remove"></i>取消</button>
                        <button class="btn btn-sm btn-primary" ng-click="handPaper()"><i class="glyphicon glyphicon-ok"></i>确定</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <include file="index.css" />
    <include file="index.js" />
</block>
