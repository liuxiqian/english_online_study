<?php
/**
 * 生词模块
 */
namespace NewWord\Model;

use Yunzhi\Model\YunzhiModel;

class NewWordModel extends YunzhiModel
{
    protected $_auto = array ( 
        array('time', 'time', 3, 'function'), 
    );
}