
    <div class="row">
        <div class="list-group">
            <li class="list-group-item active">词汇量排名</li>
            <foreach name="Student:getWordCountRank()" item="wordcount">
                <lt name="key" value="3">
                    <li class="list-group-item">
                        <div class="row">
                            <?php if($wordcount->getId() !== $Student->getId()){ ?>
                            <div class="col-md-1">
                                <h3>{$key+1}</h3>
                            </div>
                            <div class="text-left col-md-3">
                                <img class="media-object headpicture img-rounded " src="{:$wordcount->getAttachment()->getUrl()}">
                            </div>
                            <div class="text-center col-md-4">
                                <h5>{:$wordcount->getName()}</h5>
                            </div>
                            <div class="text-center col-md-2 col-md-offset-1">
                                <h5>{:$wordcount->getCurrentWordCount()}</h5>
                            </div>
                            <?php }else{  $rank0 = $key+1; ?>
                            <div class="col-md-1">
                                <h3>{$key+1}</h3>
                            </div>
                            <div class="text-left col-md-3">
                                <img class="media-object headpicture img-rounded" src="{:$wordcount->getAttachment()->getUrl()}">
                            </div>
                            <div class="text-center col-md-4">
                                <h4>{:$wordcount->getName()}</h4>
                            </div>
                            <div class="text-center col-md-2 col-md-offset-1">
                                <h4>{:$wordcount->getCurrentWordCount()}</h4>
                            </div>
                            <?php } ?>
                        </div>
                    </li>
                </lt>
            </foreach>
            <li class="list-group-item text-right listfooter">我的词汇量：{:$Student->getCurrentWordCount()} 排名：{:$rank0}
            </li>
            <li class="list-group-item active">学习速度排名(词/天)</li>
            <foreach name="Student:getCourseNewWordCountRanks()" item="newWordCount">
                <lt name="key" value="3">
                    <li class="list-group-item">
                        <div class="row">
                            <?php if($newWordCount->getId() !== $Student->getId()){ ?>
                            <div class="col-md-1">
                                <h3>{$key+1}</h3>
                            </div>
                            <div class="text-left col-md-3">
                                <img class="media-object headpicture img-rounded" src="{:$newWordCount->getAttachment()->getUrl()}">
                            </div>
                            <div class="text-center col-md-4">
                                <h5>{:$newWordCount->getName()}</h5>
                            </div>
                            <div class="text-center col-md-2 col-md-offset-1">
                                <h5>{:$newWordCount->getTodayNewWordCount()}</h5>
                            </div>
                            <?php }else{  $rank1 = $key+1; ?>
                            <div class="col-md-1">
                                <h3>{$key+1}</h3>
                            </div>
                            <div class="text-left col-md-3">
                                <img class="media-object headpicture img-rounded" src="{:$newWordCount->getAttachment()->getUrl()}">
                            </div>
                            <div class="text-center col-md-4">
                                <h4>{:$newWordCount->getName()}</h4>
                            </div>
                            <div class="text-center col-md-2 col-md-offset-1">
                                <h4>{:$newWordCount->getTodayNewWordCount()}</h4>
                            </div>
                            <?php } ?>
                        </div>
                    </li>
                </lt>
            </foreach>
            <li class="list-group-item text-right listfooter">我的速度：{:$Student->getTodayNewWordCount()} 排名：{:$rank1}
            </li>
            <li class="list-group-item active">排名统计时间：{:date("Y-m-d",time())}</li>
        </div>
    </div>
    <div class="row">
        <div class="list-group">
            <li class="list-group-item active">我的学习榜样(整体学习进度)</li>
            <?php if(empty($Student->getHeroStudySpeedRanks())) { ?>
                <li class="list-group-item">
                    <a href="{:U('Hero/index')}">指定一个学习榜样吧</a>
                </li>
            <?php } ?>
            <foreach name="Student:getHeroStudySpeedRanks()" item="wordcount">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-1">
                            <h3>{$key+1}</h3>
                        </div>
                        <div class="text-left col-md-3">
                            <img class="media-object headpicture img-rounded" src="{:$wordcount->getAttachment()->getUrl()}">
                        </div>
                        <div class="text-center col-md-4">
                            <h5>{:$wordcount->getName()}</h5>
                        </div>
                        <div class="text-center col-md-2 col-md-offset-1">
                            <h5>{:$wordcount->getStudySpeed()}%</h5>
                        </div>
                    </div>
                </li>
            </foreach>
        </div>
    </div>
