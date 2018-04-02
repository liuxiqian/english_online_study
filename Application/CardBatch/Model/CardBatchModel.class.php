<?php
/**
 *
 */
namespace CardBatch\Model;

use Yunzhi\Model\YunzhiModel;
use Card\Logic\CardLogic;

class CardBatchModel extends YunzhiModel
{
    protected $field        = "batch"; //查询字段
    protected $relationals  = null;

    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new CardLogic
            );
        }
        return parent::prepareDelete($options);
    }

}
