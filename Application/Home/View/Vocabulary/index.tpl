<extend name="Base:index" />
<block name="wrapper">
    <div class="col-md-12 col-sm-12" ng-app="mengyunzhi" ng-controller="vocabulary">
        <div class="row-fluid">
            <form action="{:U('index', I('get.'))}" method="get">
                <div class="col-md-2">
                    <div class="form-group">
                        <select name="range" class="form-control">
                            <option value="all">全部词汇</option>
                            <option value="studied" <?php if (I( 'get.range')=='studied' ) : ?>selected="selected"
                                <?php endif; ?>>学过的词汇</option>
                            <option value="studing" <?php if (I( 'get.range')=='studing' ) : ?>selected="selected"
                                <?php endif; ?>>剩余词汇</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input id="orderStudy" type="radio" checked="checked" name="order" value="study" />
                        <label for="orderStudy">&nbsp;学习顺序</label>&nbsp;
                        <input id="orderLetter" <?php if (I( 'get.order')=='letter' ) : ?>checked="checked"
                        <?php endif; ?>type="radio" name="order" value="letter" />
                        <label for="orderLetter">&nbsp;字母顺序</label>&nbsp;
                    </div>
                </div>
                <div class="col-md-offset-9 text-right">
                    <form class="form-search">
                        <div class="col-md-8">
                            <input class="form-control" value="{:I('get.title')}" type="text" name="title" placeholder="请输入单词">
                        </div>
                        <div class="col-md-1">
                            <button class="button btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> 查找</button>
                        </div>
                    </form>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!--引入panel-->
                <include file="NewVocabulary/panel" />
            </div>
        </div>
        <nav>
            <Yunzhi:page totalcount="totalCount" />
        </nav>
        <div id="alert" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display:none;margin-top: 100px; padding-right: 15px;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">您要添加到生词吗？</h4>
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
    <include file="NewVocabulary/index.css" />
    <include file="NewVocabulary/index.js" />
</block>
