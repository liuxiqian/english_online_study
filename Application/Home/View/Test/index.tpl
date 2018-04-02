<extend name="Base:index" />
<block name="wrapper">
    <include file="index.css" />
    <include file="index.js" />
    <div ng-app="yunzhi" ng-controller="Test">
        <div class="row">
            <div class="col-md-6">
                <h4>{$Test->getCourse()->getTitle()}</h4>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-lg btn-primary" ng-show="!showAnswer" ng-click="alert()">我要交卷</button>
                <eq name="Test:getIsSelfTest()" value="0">
                    <a class="btn btn-lg btn-success" ng-show="showAnswer" ng-href="{:U('Wordhome/index?id=' . $Test->getCourseId())}">返回</a>
                <else />
                    <a class="btn btn-lg btn-success" ng-show="showAnswer" ng-href="{:U('SelfTest/index')}">返回</a>
                </eq>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-10">
                <uib-tabset active="activeJustified" justified="true">
                    <?php $index = 0; $orderIndex = 0;?>
                    <?php if ($Test->getExplainCount() > 0) : ?>
                    <uib-tab index="{:$index++}" heading="释义题">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>说明：请选择词汇的正确释义。（共{:$Test->getExplainCount()}题）</h4>
                                <hr />
                            </div>
                        </div>
                        <?php $tkey = 0; ?>
                        <foreach name="Test:getExplainWords()" item="word" key="key">
                            <?php if ($tkey % 3 == 0) : ?>
                            <div class="row">
                                <?php endif; ?>
                                <div class="col-md-4">
                                    <h4>{$tkey+1}. {:$word->getTitle()}</h4>
                                    <foreach name="word:getRandomQuestionWords()" item="question">
                                        <p>
                                            <input ng-disabled="showAnswer" type="radio" name="word{:$word->getId()}" id="question{:$orderIndex}" ng-click="choose({$word->getId()}, {$question->getId()})">
                                            <label for="question{:$orderIndex++}">&nbsp; {:$question->getTranslation()}</label>
                                            <?php if ($word->getId() == $question->getId()) : ?>&nbsp;&nbsp;<i ng-show="showAnswer && checkIsWrong({$word->getId()})" class="{{rightIcon}}"></i>
                                            <?php endif; ?>
                                        </p>
                                    </foreach>
                                </div>
                                <!--如果是3的倍数，则增加一个行结束标签-->
                                <?php if (($tkey+1) % 3 == 0) : ?>
                            </div><!--row-->
                            <hr />
                            <?php endif; $tkey++;?>
                        </foreach>
                        <!--如果最后不是3的倍数，则增加一个行结束标签-->
                        <?php if (($tkey) % 3) : ?>
                            </div><!--row-->
                            <hr />
                        <?php endif; ?>
                    </uib-tab>
                    <?php endif; ?>
                    <?php if ($Test->getListeningCount() > 0) : ?>
                    <uib-tab index="{:$index++}" heading="听辨题">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>说明：请点击喇叭按钮，听到读音后，选择听到的词汇。（共{$Test->getListeningCount()}题）</h4>
                                <hr />
                            </div>
                        </div>
                        <?php $tkey = 0; ?>
                        <foreach name="Test:getListeningWords()" item="word">
                            <?php if ($tkey % 3 == 0) : ?>
                            <div class="row">
                                <?php endif; ?>
                                <div class="col-md-4">
                                    <h4>{$tkey+1}. <a href="javascript:void(0)" ng-click="speak('{:$word->getAudioUkUrl()}')" class="glyphicon glyphicon-volume-up" aria-hidden="true"></a></h4>
                                    <foreach name="word:getRandomQuestionWords()" item="question">
                                        <p>
                                            <input type="radio" ng-disabled="showAnswer" name="word{:$word->getId()}" id="question{:$orderIndex}" ng-click="choose({$word->getId()}, {$question->getId()})">
                                            <label for="question{:$orderIndex++}">&nbsp; {:$question->getTitle()}</label>
                                            <?php if ($word->getId() == $question->getId()) : ?>&nbsp;&nbsp;<i ng-show="showAnswer && checkIsWrong({$word->getId()})" class="{{rightIcon}}"></i>
                                            <?php endif; ?>
                                        </p>
                                    </foreach>
                                </div>
                                <!--如果是3的倍数，则增加一个行结束标签-->
                                <?php if (($tkey+1) % 3 == 0) : ?>
                            </div><!--row-->
                            <hr />
                            <?php endif; $tkey++;?>
                        </foreach>
                        <?php if (($tkey) % 3) : ?>
                            <!--如果最后不是3的倍数，则增加一个行结束标签-->
                            </div><!--row-->
                            <hr />
                        <?php endif; ?>
                    </uib-tab>
                    <?php endif; ?>
                    <?php if ($Test->getWriteCount() > 0) : ?>
                    <uib-tab index="{:$index++}" heading="听写题">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>说明：请点击喇叭按钮，听到读音后，拼写正确的单词。（共{$Test->getWriteCount()}题）</h4>
                                <hr />
                            </div>
                            <div class="col-md-4" ng-repeat="word in writeWords">
                                <h4>{{ $index+1 }}. <a href="javascript:void(0)" ng-click="speak(word.audioUkUrl)" class="glyphicon glyphicon-volume-up" aria-hidden="true"></a></h4>
                                <input ng-disabled="showAnswer" type="text" ng-model="word.defaultWriteAnswer" ng-change="write(word)" />&nbsp;&nbsp;<span ng-show="showAnswer && checkIsWrong(word.id)" class="text-success" ng-bind="word.title"></span>
                            </div>
                        </div>
                    </uib-tab>
                    <?php endif; ?>
                </uib-tabset>
            </div>
            <div class="col-md-2">
                <div class="list-group">
                    <a href="#" class="list-group-item active">
                        <h4 class="list-group-item-heading">剩余时间</h4>
                        <h4><font color="{{numColor}}" ng-bind="mum | secondsToDateTime | date:'HH:mm:ss'"></font></h4>
                        <h4 class="list-group-item-heading">未完成题数</h4>
                        <h4><font color="red" ng-bind="totalCount - rights.length - wrongs.length"></font></h4>
                    </a>
                </div>
            </div>
        </div>
        <audio id="audio"></audio>
        <div id="score" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display:none;margin-top: 100px;padding-right: 15px;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">您的作答情况如下：</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            共{{totalCount}}题
                            <br /> 答对{{rights.length || 0}}题
                            <br /> 答错{{wrongs.length || 0}}题
                            <br /> 未答{{totalCount - rights.length - wrongs.length}}题
                        </p>
                        <h5>得分:{{score}}</h5>
                    </div>
                    <div class="modal-footer">
                        <div ng-show="info" class="alert alert-success text-center" role="alert" ng-bind="info"></div>
                        <button class="btn btn-md btn-primary"  ng-click="commit()" ng-disabled="submitDisable"><i class="glyphicon glyphicon-ok"></i>&nbsp;{{submitTitle}}</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div id="alert" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display:none;margin-top: 100px; padding-right: 15px;">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title" id="mySmallModalLabel">您还有<span class="text-danger">{{totalCount - rights.length - wrongs.length}}</span>题未作答，确认要交卷吗？</h4>
                    </div>
                    <div class="modal-body text-center">
                        <button class="btn btn-md btn-danger" ng-click='cancel()'><i class="glyphicon glyphicon-remove"></i>&nbsp;取消</button>
                        <button class="btn btn-md btn-primary" ng-click="handPaper()"><i class="glyphicon glyphicon-ok"></i>&nbsp;交卷</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</block>
