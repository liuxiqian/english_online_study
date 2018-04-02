<?php
/**
 组测百分比* 
 */
namespace TestPercent\Model;

use Yunzhi\Model\YunzhiModel;
use Test\Logic\TestLogic;

class TestPercentModel extends YunzhiModel
{
    // array('value',array(1,2,3),'值的范围不正确！',2,'in'), 
    protected $orderBys     = array("percent"=>"desc");  //排序字段方式

    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new TestLogic
            );
        }
        return parent::prepareDelete($options);
    }
}