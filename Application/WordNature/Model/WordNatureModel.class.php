<?php
/**
 单词属性信息* 
 */
namespace WordNature\Model;

use Yunzhi\Model\YunzhiModel;
use WordWordNature\Logic\WordWordNatureLogic;         // 单词属性关系表

class WordNatureModel extends YunzhiModel
{
	protected $field = "name";

    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new WordWordNatureLogic
            );
        }
        return parent::prepareDelete($options);
    }
}