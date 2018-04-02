<?php
/**
 * 卡密类
 */
namespace Home\Model;

use Card\Logic\CardLogic;               //卡密数据表

class Card
{
    private $id = 0;                    //卡密id
    private $cardBatchId = 0;           // 卡密批次
    private $CardBatch = null;          //卡密批次对象

    public function __construct($id = 0)
    {
        $map = array();
        $map['student_id'] = (int)$id;
        $CardL = new CardLogic();
        $data = $CardL->where($map)->find();    //取学生对应的卡密数据
        if($data !== null)
        {
            $this->id = (int)$data['id'];
            $this->cardBatchId = (int)$data['card_batch_id'];
        }
        unset($CardL);
    }

    public function getId()
    {
        return (int)$this->id;
    }
    
    public function getCardBatch()
    {
        if (null === $this->CardBatch)
        {
            $this->CardBatch = new CardBatch($this->getCardBatchId());
        }
        return $this->CardBatch;
    }

    public function getCardBatchId()
    {
        return (int)$this->cardBatchId;
    }

    /**
     * 获取 学生 对应的卡密信息
     * @param  Student &$Student 学生
     * @return Card           卡密
     * @author panjie <panjie@yunzhiclub.com>
     */
    static public function getByStudent(&$Student)
    {
        if (!is_object($Student) || (get_class($Student) !== 'Home\Model\Student'))
        {
            E('传入的变量类型非Student');
        }

        // 查询卡密
        $CardL = new CardLogic;
        $map = array();
        $map['student_id'] = $Student->getId();
        $data = $CardL->where($map)->find();

        if (null === $data)
        {
            return new Card();
        }

        return new Card($data['id']);
    }
}