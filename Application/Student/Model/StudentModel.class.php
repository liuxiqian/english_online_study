<?php

namespace Student\Model;

use Yunzhi\Model\YunzhiModel;
use Card\Logic\CardLogic;
use Test\Logic\TestLogic;
use RepeatTimes\Logic\RepeatTimesLogic;
use NewWord\Logic\NewWordLogic;
use Login\Logic\LoginLogic;//登录

class StudentModel extends YunzhiModel
{
    protected $field        = "name"; //查询字段

    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new TestLogic,
                new RepeatTimesLogic(),
                new LoginLogic(),
                new NewWordLogic()
            );
        }
        if (empty($this->dependencies))
        {
            $this->dependencies = array(
                new CardLogic
            );
        }
        return parent::prepareDelete($options);
    }

    protected $_auto = array(
        array("creation_date", "time", 1, 'function'),
        );

    /**
     * 生成加密后的密码
     * @param  string $password 
     * @return string           
     */
    static public function makePassword($password)
    {
        return sha1(strtoupper(md5($password)));
    }

    //覆盖saveList方法
    public function saveList($list)
    {
        if (isset($list['password']))
        {
            $list['password'] = $this->makePassword($list['password']);
        }
        return parent::saveList($list);
    }
}
