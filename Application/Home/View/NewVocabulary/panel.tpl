<div class="panel-body">
    <div class="alert alert-success" ng-show="info" role="alert" ng-bind="info"></div>
    <audio id="audio">您的浏览器不支持HTML5，一些功能将会产生限制
    </audio>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
            <tr class="info">
                <th width="18%" ng-click="toggleAll('title')"><a href="javascript:void(0)"><span ng-hide="showTitle">显示</span><span ng-show="showTitle">隐藏</span>所有词汇</a></th>
                <th width="10%">播放</th>
                <th width="27%" ng-click="toggleAll('explains')"><a href="javascript:void(0)"><span ng-hide="showExplain">查看</span><span ng-show="showExplain">隐藏</span>所有释义</a></th>
                <th width="27%">扩展信息</th>
                <th width="9%">难度</th>
                <th width="9%">记忆词汇</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="word in words">
                <td ng-click="toggleExplain(word, 'title')"><span ng-show="word.showTitle" ng-bind="word.title"></span><span class="text-center" ng-hide="word.showTitle">?</span></td>
                <td><a ng-click="play(word)" href="javascript:void(0)"><span class="glyphicon glyphicon-volume-up"></span></a>&nbsp;
                    <?php if (CONTROLLER_NAME == 'Vocabulary') : ?>
                    <a href="javascript:void(0)" ng-click="add(word)" class="glyphicon glyphicon-plus"></a>
                    <?php else : ?>
                    <a href="javascript:void(0)" ng-click="remove(word)" class="glyphicon glyphicon-minus"></a>
                    <?php endif; ?>
                </td>
                <td class="hidecolor" ng-click="toggleExplain(word, 'explain')">
                    <span ng-show="word.showExplain" ng-bind="word.explain"></span>
                    <span class="text-center" ng-hide="word.showExplain">?</span>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0)" ng-click="showExtends(word)"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <div ng-show="word.show" ng-class="randAnimate($index)" class="text-left extend">
                        <div ng-repeat="extend in word.extends">
                            <h5>{{extend.WordNature.title}}</h5>
                            <ul>
                                <li ng-repeat="WordWordNature in extend.WordWordNatures">{{WordWordNature.title}}:{{WordWordNature.explain}}</li>
                            </ul>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="star" ng-bind-html="word.star | starFormat">
                    </div>
                </td>
                <td class="text-center">
                    <?php if (CONTROLLER_NAME == 'Vocabulary') : ?>
                        <a class="text-success" href="{:U('Study/allwordsReview')}?wordId={{word.id}}"><span class="glyphicon glyphicon-play-circle"></span></a>
                    <?php else : ?>
                    <a class="text-success" href="{:U('Study/newWordsReview')}?wordId={{word.id}}"><span class="glyphicon glyphicon-play-circle"></span></a>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
