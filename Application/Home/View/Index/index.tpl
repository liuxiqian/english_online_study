<extend name="Base:index"/>
<block name="wrapper">
    <div class="row">
        <div class="col-md-12" ng-app="myApp" ng-controller="MyCourse">
            <section id="about" class="about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 studyInfo">
                            {:$Student->getName()}</b>，欢迎您!&nbsp;&nbsp;您现已开通{:$Student->getKlass()->getCourseCount()}个课程，
                            学习{:$Student->getStudyTime()}次， 累计{:$Student->getTotalStudyMin()}分钟，
                            上次学习日期：{:date("Y年m月d日",$Student->getLastStudyTime())}。
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
            </section>
            <div class="row row2">
                <div class="col-md-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <h2>Studing Courses</h2>
                                <hr class="small">
                                <div class="row">
                                    <foreach name="Student:getStudyCourses()" item="Course">
                                        <div class="col-md-4">
                                            <a class="list-quotes" href="{:U('Wordhome/index?id=' . $Course->getId())}">
                                                <eq name="Course:getAttachmentUrl()" value="null">
                                                    <img class='img-responsive' alt="img"
                                                     src="__ROOT__/images/course-1.jpg">
                                                    <else/>
                                                    <img class='img-responsive' alt="img"
                                                     src="{:$Course->getAttachmentUrl()}">
                                                    </eq>
                                                
                                                <div class="quotes">
                                                    <h1>{:$Course->getProgressPercent($Student)}%</h1>
                                                    <p>
                                                        新学{:$Course->getNewStudyWordsCount($Student)}词,
                                                        &nbsp;复习{:$Course->getOldStudyWordsCount($Student)}
                                                        词,&nbsp;共{:$Course->getWordCount()}词。<span></span>
                                                    </p>
                                                </div>
                                            </a>
                                            <h4>{:$Course->getTitle()}</h4>
                                        </div>
                                    </foreach>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        <div class="col-lg-12 text-center">
                            <h2 ng-click="allClass()"><a href="javascript:void(0);">All Courses</a></h2>
                            <hr class="small">
                            <div class="row" ng-show="myCheck">
                                <foreach name="Student:getAllCourses()" item="Course">
                                    <div class="col-md-3">
                                        <a class="list-quotes" href="{:U('Wordhome/index?id=' . $Course->getId())}">
                                            <eq name="Course:getAttachmentUrl()" value="null">
                                                    <img class='img-responsive' alt="img"
                                                     src="__ROOT__/images/course-1.jpg">
                                                    <else/>
                                                    <img class='img-responsive' alt="img"
                                                     src="{:$Course->getAttachmentUrl()}">
                                                    </eq>
                                            <div class="quotes">
                                                <h1>{:$Course->getProgressPercent($Student)}%</h1>
                                                <p>
                                                    新学{:$Course->getNewStudyWordsCount($Student)}词,
                                                    &nbsp;复习{:$Course->getOldStudyWordsCount($Student)}
                                                    词,&nbsp;共{:$Course->getWordCount()}词。<span></span>
                                                </p>
                                            </div>
                                        </a>
                                        <h4>{:$Course->getTitle()}</h4>
                                    </div>
                                </foreach>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row4">
                <div class="col-md-12">
                    <div class="container">
                        <h2 class="text-center">Reading</h2>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12" style="">
                                <div class="panel panel-default list-group-panel">
                                    <div class="panel-body">
                                        <ul class="list-group list-group-body" style="">
                                            <foreach name="Student:getKlass():getArticles()" item="article">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-xs-10 text-left" style=" "><span class="glyphicon glyphicon-hand-right"></span>&nbsp;&nbsp;<a href="{:U('Article/index?id=' . $article->getId())}">{$article->getTitle()}</a></div>
                                                    <div class="col-xs-1 col-xs-push-1 text-left"><a href="{:U('Article/index?id=' . $article->getId())}" class="btn-success btn-xs btn">GO <span class="glyphicon glyphicon-triangle-right"></span></a></div>
                                                </div>
                                            </li>
                                            </foreach>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <include file="index.js"/>
    <include file="index.css"/>
</block>
