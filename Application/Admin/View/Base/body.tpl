<block name="page-wrapper">
    <div id="page-wrapper" ng-app="body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-header">
                <?php
                {
                    $breadCrubms = $ConstructM->getBreadCrumbs();
                    if (!empty($breadCrubms))
                    {
                        $count = count($breadCrubms);
                        for ($i = $count - 1, $j = 0; $i >= 0; $i--, $j++)
                        {
                            if ($j)
                            {
                                echo '&nbsp;>>&nbsp;';
                            }
                            echo $breadCrubms[$i]['title'];
                        }
                    }
                }
                ?></h4>
            </div>
        </div>
        <block name="wrapper">
        <div class="panel panel-default">
            <div class="panel-heading">
                <block name="title">
                    这里是需要覆盖的标题
                </block>
                <block name="pageSize">
                <eq name="ACTION_NAME" value="index">

                    <div class="pull-right"  ng-controller="pageSize" >
                        <select ng-model="pagesize" ng-change="pagesizeChange()">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </eq>
                </block>
            </div>
            <div class="panel-body">
                <block name="body">
                </block>
            </div>
        </div>
        </block>
        <div style="clear:both;display:block;width:100%;height:0px"></div>
    </div><!--/#page-wrapper-->
</block>
