<extend name="Base:index" />
<block name="title">
    词汇管理
</block>
<block name="body">
    <php>$courseid = I('get.courseid') === "" ? 0 : I('get.courseid'); $order = (I('get.order') == 'desc') ? 'asc' : 'desc';
    </php>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">对单词进行添加、删除后，务必要进行单词顺序的重新整理。请勿删除已上线课程的单词，这将对前台学生的学习进度带来一定的影响。</div>
        </div>
    </div>
    <form name="form" ng-controller="WordIndex" action="?" method="get">
        <div class="col-md-3">
            <select name="courseid" class="form-control" id="coureseid">
                <option value="0">请选择</option>
                <foreach name="M:getAllCourseLists()" item="course">
                    <option value="{$course['id']}" <eq name="courseid" value="$course['id']">selected="selected"</eq>>{$course['title']}</option>
                </foreach>
            </select>
        </div>
        <div class="col-md-3">
            <div class="input-group custom-search-form">
                <input class="form-control" name="keywords" placeholder="单词.." type="text" value="" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="fa fa-search"></i>
                    </button> 
                </span>
            </div>
        </div>
        <div class="col-md-2 col-md-offset-4">
            <neq name="courseid" value="0"></neq>
            <Yunzhi:access a="add"><a class="btn btn-info" href="{:U('add', I('get.'))}"><i class="glyphicon glyphicon-plus"></i> 新增</a></Yunzhi:access>
        </div>
        <div class="panel-body">
        </div>
        <table class="table table-bordered table-striped table-hover">
            <tr>
                <th>序号</th>
                <th>单词</th>
                <th>基本释义</th>
                <th>操作</th>
            </tr>
            <foreach name="lists" item="list" key="key">
                <tr>
                    <td>{$key+1}</td>
                    <td><Yunzhi:access a="edit"><a href="{:U('edit?id=' . $list['id'], I('get.'))}">{$list['title']}</a><else />{$list['title']}</Yunzhi:access></td>
                    <td>{$list['translation']}</td>
                    <td>
                        <Yunzhi:access a="delete"><a class="btn btn-sm btn-danger" ng-href="{:U('delete?id=' . $list['id'], I('get.'))}"><i class="fa fa-trash-o "></i> 删除</a></Yunzhi:access>
                    </td>
                </tr>
            </foreach>
        </table>
        <Yunzhi:page />
    </form>
    <include file="index.js" />
</block>
