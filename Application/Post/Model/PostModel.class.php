<?php
namespace Post\Model;

use Yunzhi\Model\YunzhiModel;
use DepartmentPost\Logic\DepartmentPostLogic;         // 部门
use MenuPost\Logic\MenuPostLogic;         // 菜单岗位

/**
* 岗位管理
*/
class PostModel extends YunzhiModel
{
	protected $orderBys                 = array("id"=>"asc");  //排序字段方式
	protected $field                    = "name";          //查询字段

    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new MenuPostLogic,
                new DepartmentPostLogic
            );
        }
        return parent::prepareDelete($options);
    }

}