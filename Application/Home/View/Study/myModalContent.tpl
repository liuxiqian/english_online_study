<div class="modal-header">
    <h3 class="modal-title">练一练</h3>
</div>
<div class="modal-body">
    <div class="row">
        <form id="form" name="form" class="form-inline">
            <input id="exercise" my-enter="repeat()" class="form-control" type="text" name="exercise" ng-model="exercise" ng-change="change()" />&nbsp;&nbsp;
            <label class="contro-label">
                <i class="glyphicon glyphicon-remove text-danger" ng-show="form.$dirty && !right"></i><i class="glyphicon glyphicon-ok text-success" ng-show="form.$dirty && right"></i>
            </label>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" type="button" ng-click="repeat()"><i class="glyphicon glyphicon-refresh"></i>&nbsp;再练一次</button>
    <button class="btn btn-warning" type="button" ng-click="cancel()"><i class="glyphicon glyphicon-remove"></i>&nbsp;关闭</button>
</div>
