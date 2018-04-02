<?php
/**
 * 卡密批次类
 */
namespace Home\Model;

use CardBatch\Logic\CardBatchLogic;         //卡密批次数据表

class CardBatch
{
    private $id = 0;                    // 卡密批次id
    private $effectiveDays = 0;         // 卡密批次有效天数
    private $deadline = 0;              // 卡密批次的截止时间

    public function __construct($id = 0)
    {
        $map['id'] = $id;
        $CardBatchL = new CardBatchLogic();
        $data = $CardBatchL->where($map)->find();     //取卡密对应的卡密批次数据
        if (null !== $data )
        {
            $this->id = $data['id'];
            $this->effectiveDays = $data['effective_days'];
            $this->deadline = $data['deadline'];
        }
        unset($CardBatchL);
    }

    //获取本类对象的id
    public function getId()
    {
        return $this->id;
    }

    //获取本类对象的有效期天数
    public function getEffectiveDays()
    {
        return $this->effectiveDays;
    }

    //获取本类对象的截止时间
    public function getDeadline()
    {
        return $this->deadline;
    }
}