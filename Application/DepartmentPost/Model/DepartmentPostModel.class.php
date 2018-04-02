<?php
/**
 * 部门岗位
 * panjie
 * 2016.04
 */
namespace DepartmentPost\Model;

use Yunzhi\Model\YunzhiModel;
use User\Logic\UserLogic;         // 用户

class DepartmentPostModel extends YunzhiModel
{
    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->dependencies))
        {
            $this->dependencies = array(
                new UserLogic
            );
        }
        return parent::prepareDelete($options);
    }
}