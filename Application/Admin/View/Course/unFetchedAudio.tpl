<extend name="Base:index" />
<block name="title">
    未抓取到读音的单词
</block>
<block name="body">
<table>
    <tr>
        <th>序号</th>
        <th>单词</th>
        <th>操作</th>
    </tr>
    <foreach name="Course:getUnFetchedAudioWords()" item="word">
    <tr>
        <td>{$key+1}</td>
        <td>{$word->getTitle()}</td>
        <td><Yunzhi:access c="word" a="edit"><a href="{:U('Word/edit?from=course&courseid=' . $Course->getId() . '&id=' . $word->getId())}">编辑</a></Yunzhi:access></td>
    </tr>
    </foreach>
</table>
</block>