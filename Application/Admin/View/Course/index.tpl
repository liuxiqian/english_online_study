<extend name="Base:index" />
<block name="title">
    课程列表
</block>
<block name="body">
    <div class="row">
        <div class="col-md-12">
            <Yunzhi:access a="add"><a href="{:U('add?id=', I('get.'))}" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> 新增</a></Yunzhi:access>
            <php>$showUnFetchedAudioFileCount = I('get.showUnFetchedAudioFileCount') ? 0 : 1;</php>
            <a class="btn btn-success" href="{:U('?showUnFetchedAudioFileCount=' . $showUnFetchedAudioFileCount, I('get.'))}"><i class="glyphicon glyphicon-retweet"></i>&nbsp;切换语音缺失数</a>
            <span class="alert alert-danger">获取语音缺失数将耗费较多的服务器资源，请勿频繁使用</span>
        </div>
    </div>
    <table class="table table-bordered table-striped table-hover">
        <div class="panel-body">
        </div>
        <tr>
            <th>序号</th>
            <?php $order=I('get.order') ?>
            <th><a href="<eq name='order' value='desc'> {:U('index?by=title&order=asc', I('get.'))}<else/> {:U('index?by=title&order=desc', I('get.'))} </eq>">课程名</a></th>
            <th>组测个数</th>
            <th>阶段测个数</th>
            <th>单词总数</th>
            <th>读音缺失</th>
            <th>操作</th>
        </tr>
        <foreach name="M:getLists()" item="course" key="key">
            <tr>
                <td>{$key+1}</td>
                <td>{$course->getTitle()}</td>
                <td>{$course->getCountByTestType(1)}</td>
                <td>{$course->getCountByTestType(2)}</td>
                <td><Yunzhi:access c="Word" a="index"><a href="{:U('Word/index?courseid=' . $list['id'])}">{$course->getWordCount()}</a><else />{:$course->getWordCount()}</Yunzhi:access></td>
                <td><eq name="showUnFetchedAudioFileCount" value="1">-<else /><Yunzhi:access a="unFetchedAudio"><a href="{:U('unFetchedAudio?id=' . $course->getId(), I('get.'))}">{$course->getUnFetchedAudioCount()}</a><else />{$course->getUnFetchedAudioCount()}</Yunzhi:access></eq></td>
                <td>
                    <Yunzhi:access a="edit"><a class="btn btn-sm btn-primary" ng-href="{:U('edit?id=' . $course->getId(), I('get.'))}"><i class="fa fa-pencil"></i>&nbsp;编辑</a></Yunzhi:access>
                    <Yunzhi:access c="TestPercent" a="index"><a class="btn btn-sm btn-warning" ng-href="{:U('TestPercent/index?courseId=' . $course->getId(), I('get.'))}"><i class="fa fa-pencil"></i>&nbsp;编辑测试</a></Yunzhi:access>
                    <Yunzhi:access a="delete"><a class="btn btn-sm btn-danger" href="{:U('delete?id='.$course->getId(), I('get.'))}"><i class="fa fa-trash-o "></i>&nbsp;删除</a></Yunzhi:access>
                </td>
            </tr>
        </foreach>
    </table>
    <nav>
         <Yunzhi:page totalcount="M:getTotalCount()" />
    </nav>

    <include file="index.js" />
</block>
