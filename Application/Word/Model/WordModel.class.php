<?php
/**
 * 单词
 */
namespace Word\Model;

use Yunzhi\Model\YunzhiModel;
use WordExplain\Logic\WordExplainLogic;
use NewWord\Logic\NewWordLogic;
use WordProgress\Logic\WordProgressLogic;
use RepeatTimes\Logic\RepeatTimesLogic;
use WordWordNature\Logic\WordWordNatureLogic;

class WordModel extends YunzhiModel
{  
    protected $orderBys = array("order" => "asc", "id" => "asc");  
    
    /**
     * 重写YUNZHIMODE中的 预删除
     * @param  array  &$options 查询条件
     * @return bool
     * panjie
     */
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new WordExplainLogic, 
                new NewWordLogic, 
                new WordProgressLogic, 
                new RepeatTimesLogic, 
                new WordWordNatureLogic
            );
        }
        return parent::prepareDelete($options);
    }
}