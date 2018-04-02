<?php
/**
* 测试查询
*/
namespace Test\Model;

use Yunzhi\Model\YunzhiModel;

class TestModel extends YunzhiModel
{
    protected $_auto = array(
        array('time','time',1,'function'),
    );
    protected $_validate = array(
         array('student_id','require','student_id is required',1),
         array('test_percent_id','require','test_percent_id is required',1),
        );
    protected $orderBys     = array("time"=>"desc"); //排序字段方式
    //protected $field        = "title";  student_name            //查询字段
}