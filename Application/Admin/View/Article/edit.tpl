<extend name="Base:index" />
<block name="title">
    阅读闯关
</block>
<block name="body">
    <div class="row-fluid" ng-controller="articleEdit">
        <div class="col-md-12">
            <form class="form-horizontal" name="" action="{:U('save?id=', I('get.'))}" method='post'>
                <input type="hidden" name="id" value="{$Article->getId()}" />
                <div class="form-group">
                    <label for="title" class="col-md-2 control-label">标题</label>
                    <div class="col-md-4">
                        <input name="title" class="form-control" value="{$Article->getTitle()}" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-md-2 control-label">原文</label>
                    <div class="col-md-10">
                        <html:editor id="english_text" type="Ueditor" name="english_text">
                            {$Article->getEnglishText() | htmlspecialchars_decode}
                        </html:editor>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-md-2 control-label">译文</label>
                    <div class="col-md-10">
                        <html:editor id="chinese_text" type="Ueditor" name="chinese_text">
                            {$Article->getChineseText() | htmlspecialchars_decode}
                        </html:editor>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="attachment_id" value="{{audio.id}}" />
                    <label for="username" class="col-md-2 control-label">音频文件</label>
                    <div class="col-md-10">
                        <audio id="audio" ng-show="showPlayer" style="width:25%;" controls>请使用支持html5的浏览器</audio>
                        <button type="button" class="btn btn-sm btn-info" id="playbutton" ng-show="!showPlayer && showPlay" ng-click="togglePlay()"><i class="glyphicon glyphicon-headphones"></i>&nbsp;Play</button>
                        <button class="btn btn-sm btn-primary" type="button" ngf-select="uploadAudio($file)" ngf-max-files="1" ngf-max-size="10MB" accept="audio/mpeg"><i class="glyphicon glyphicon-upload"></i>&nbsp;导入</button>
                    </div>
                    <div class="col-md-4 col-md-push-2 alert alert-success" ng-show="info" ng-bind="info" role="alert"></div>
                </div>
                <div class="text-center">
                    <button class="btn btn-md btn-success" type="submit"><i class="glyphicon glyphicon-ok"></i>&nbsp;保存</button>
                </div>
            </form>
        </div>
        <include file="Base/js" />
        <include file="edit.js" />
    </div>
</block>
