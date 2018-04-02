<?php
/**
 * 单词进度信息
 */
namespace WordProgress\Model;

use Yunzhi\Model\YunzhiModel;

class WordProgressModel extends YunzhiModel
{
    protected $_auto = array(
        array('time', 'time', 1, 'function'),
        );
}