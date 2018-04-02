<extend name="Base:index" />
<block name="wrapper">
    <div class="col-md-12 col-sm-6" ng-app="analysis">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    {$Notes->getText() | htmlspecialchars_decode}
                </div>
            </div>
        </div>
    </div>
</block>