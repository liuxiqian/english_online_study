<extend name="Base:index" />
<block name="title">
    清除缓存
</block>
<block name="pageSize">
</block>
<block name="body">
    <div class="row-fluid">
        <div class="col-md-12">
            <neq name="status" value="-1">
                <eq name="status" value="0">
                        <div class="alert alert-success" role="alert">缓存清理成功</div>
                    <else />
                    <div class="alert alert-danger" role="alert">
                    操作失败:<hr />
                    <ul>
                    <?php
                        foreach ($result as $k => $value)
                        {
                            echo '<li>' . $value . '</li>';
                        }
                    ?>
                    </ul>
                    </div>
                </eq>
            </neq>
            <a class="btn btn-md btn-primary" href="{:U('?action=clear')}">马上清理</a>
        </div>
    </div>
</block>
