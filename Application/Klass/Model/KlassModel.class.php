<?php
/**
 * 班级管理
 */
namespace Klass\Model;

use Yunzhi\Model\YunzhiModel;
use Student\Logic\StudentLogic;
use KlassCourse\Logic\KlassCourseLogic;

class KlassModel extends YunzhiModel
{
    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new KlassCourseLogic
            );
        }
        if (empty($this->dependencies))
        {
            $this->dependencies = array(
                new StudentLogic
            );
        }
        return parent::prepareDelete($options);
    }

    protected $_auto = array(
        array('create_time','time',1,'function'),
    );
    protected $_validate = array(
        array('name','require','class name is required',1),
        array('user_id','require','user_id is required',1),
        );
    protected $orderBys     = array("user_id"=>"asc"); //排序字段方式
    //protected $field        = "user_name";              //查询字段
}