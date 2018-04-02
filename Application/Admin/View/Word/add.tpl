<!--
    词汇管理 
    panjie
    2016.04.11
-->
<extend name="Base:index" />
<block name="title">
    <?php $id = (int)$data['id']; ?>
    <eq name="id" value="0">添加词汇
        <else />编辑词汇</eq>
</block>
<block name="body">
    <div class="row" ng-controller="index">
        <form name="form" action="{:U('save', I('get.'))}" method="post">
            <div class="col-md-11 col-md-push-1">
                <div class="row">
                    <div class="col-md-12">
                        当前课程{:$M->course['title']}
                        <input type="hidden" name="course_id" value="{:$M->courseId}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">排序</span>
                            <select name="order" class="form-control">
                                <foreach name="M:getCrouseLists()" item="orderWord">
                                    <option value="{$orderWord['order']}" <eq name="orderWord['selected']" value="true">selected="selected"</eq>>{$orderWord['title']}</option>
                                </foreach>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">单词</span>
                            <input type="text" id="title" name="title" class="form-control" ng-model="data.title" aria-describedby="basic-addon1" required />
                            <input type="hidden" name="id" value="{{data.id}}" />
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" ng-click="query()">抓取数据</button>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">音节</span>
                            <input type="text" id="syllable" name="syllable" value="" class="form-control" ng-model="data.syllable" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">释义</span>
                            <input type="text" id="translation" name="translation" value="" class="form-control" ng-model="data.translation" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">音标(英)</span>
                            <label for="uk_phonetic"></label>
                            <input type="text" id="uk_phonetic" name="uk_phonetic" value="" class="form-control" ng-model="data.uk_phonetic" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">音标(美)</span>
                            <label for="us_phonetic"></label>
                            <input type="text" id="us_phonetic" name="us_phonetic" value="" class="form-control" ng-model="data.us_phonetic" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">难度星级</span>
                            <select ng-model="data.star" name="star" class="form-control">
                                <option value="0">1</option>
                                <option value="1">2</option>
                                <option value="2">3</option>
                                <option value="3">4</option>
                                <option value="4">5</option>
                            </select>
                        </div>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-md-6 form-group">
                        <div class="input-group" ng-repeat="explain in data.explains track by $index">
                            <span class="input-group-addon" id="basic-addon1">词性</span>
                            <input type="text" name="explain[]" class="form-control" ng-model="data.explains[$index]" aria-describedby="basic-addon1" /><span class="input-group-btn" ng-click="changeExplain(explain, $index)"><button ng-show="$index" class="btn btn-default" type="button"><i class="glyphicon glyphicon-minus"></i></button><button ng-show="!$index" class="btn btn-default" type="button"><i class="glyphicon glyphicon-plus"></i></button></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">例句</span>
                            <input type="text" id="example" name="example" class="form-control" ng-model="data.example" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">例句释义</span>
                            <input type="text" id="example_translate" name="example_translate" class="form-control" ng-model="data.example_translate" aria-describedby="basic-addon1" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        扩展信息:
                        <button type="button" class="addNature">+</button>
                    </div>
                    <div class="col-md-10" id="wordNatures">
                        <foreach name="M:getWordWordNatureLists()" item="wordWordNature">
                            <div class="row wordNature">
                                <select name="word_nature_id[]">
                                    <foreach name="M:getWordNatureLists()" item="wordNature">
                                        <option value="{$wordNature['id']}" <eq name="wordWordNature['word_nature_id']" value="$wordNature['id']">selected="selected"</eq>>{$wordNature['name']}</option>
                                    </foreach>
                                </select>
                                <input type="text" name="word_word_nature_title[]" value="{$wordWordNature['title']}" />&nbsp;释义:<input type="text" name="word_word_nature_explain[]" value="{$wordWordNature['explain']}"/>
                                <button class="subNature" type="button">-</button>
                            </div>
                        </foreach>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        单词图片
                        <img ng-src="{{data.attachment_url}}" ng-show="data.attachment_url" />
                        <p>(如果您看到的图片过大，那么将影响学习平台的加载速度，建议您用QQ截图等软件进行二次处理。</p>
                        <input type="hidden" class="form-control" aria-describedby="basic-addon1" name="attachment_id" value="{{data.attachment_id}}" />
                        <div class="btn btn-primary" ngf-select="upload($file)" ngf-max-files="1" ngf-max-size="1MB" accept="image/*"><i class="glyphicon glyphicon-picture"></i>&nbsp;选择图片</div>
                    </div>
                </div>

                <div class="text-center">
                    <Yunzhi:access a="save">
                        <button type="submit" ng-show="form.title.$valid" class="btn btn-success"><i class="fa fa-check "></i>&nbsp;确认</button>
                    </Yunzhi:access>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            注意：添加单词时，无需要手动上传读音文件。当且仅当『批量抓取单词读音』后，读音仍然不存在时，才有必要手动对其进行维护。
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            音频文件MP3(英)：<span class="{{data.audios.uk.showClass}}" ng-bind="data.audios.uk.tips"></span><div class="btn-sm btn-primary" ngf-select="uploadAudio($file, 'uk')" ngf-max-files="1" ngf-max-size="1MB" accept="audio/mpeg"><i class="glyphicon glyphicon-upload"></i>&nbsp;上传</div>
                        </div>
                    </div>
                    <div class="col-md-3 form-group">
                        <div class="input-group">
                            音频文件MP3(美)：<span class="{{data.audios.us.showClass}}" ng-bind="data.audios.us.tips"></span><div class="btn-sm btn-primary" ngf-select="uploadAudio($file, 'us')" ngf-max-files="1" ngf-max-size="1MB" accept="audio/mpeg"><i class="glyphicon glyphicon-upload"></i>&nbsp;上传</div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-success" role="alert" ng-bind="alert" ng-show="alert"></div>
            </div>
        </form>
    </div>
    <include file="add.js" />
</block>
