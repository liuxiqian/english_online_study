<?php
/**
 学生登录信息* 
 */
namespace Login\Model;

use Yunzhi\Model\YunzhiModel;
use WordProgress\Logic\WordProgressLogic;

class LoginModel extends YunzhiModel
{
    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new WordProgressLogic
            );
        }
        return parent::prepareDelete($options);
    }

    protected $_auto = array(
        array("time", "time", 1, "function")
        );
}