<?php
/**
*疲劳指数类
*zhangjiahao
*2016.5.3
*/
namespace Home\Model;
use IndexOfFatigue\Logic\IndexOfFatigueLogic;

class IndexOfFatigue
{
    private $id       = 0;              // 疲劳指数id
    private $title    = "我是超人";      // 疲劳指数中设置时间的名称
    private $value    = 36000;          // 疲劳指数中设置时间的名称值(秒)

    //传$id的原因是$id在数据表中唯一存在，可以确定该数据表。
    public function __construct($id)
    {
        $id = (int)$id;
        $IndexOfFatigueL = new IndexOfFatigueLogic();

        $indexOfFatigue = $IndexOfFatigueL->where("id = $id")->find();
        if ($indexOfFatigue === null)
        {
            return;
        }

        $this->id = $id;
        $this->title = $indexOfFatigue['title'];
        $this->value = $indexOfFatigue['value'];
    }

    //获取学生id
    public function getId()
    {
        return $this->id;
    }

    // 获取本类名称
    public function getTitle()
    {
        return $this->title;
    }

    //获取本类疲劳指数时间值
    public function getValue()
    {
        return $this->value;
    }

    // 获取疲劳指数时间值（分钟）
    public function getValueMinite()
    {
        if (null === $this->valueMinite)
        {
            $this->valueMinite = floor($this->getValue() / 60);
        }
        return $this->valueMinite;
    }

    // 获取疲劳指数时间值（毫秒）
    public function getValueMs()
    {
        if (null === $this->ValueMs)
        {
            $this->ValueMs = floor($this->getValue() * 1000);
        }
        return $this->ValueMs;
    }

    // 获取疲劳指数的列表
    public function getAllLists()
    {
        $id = $this->id;
        $lists = array();
        $result = array();
        $IndexOfFatigueL = new IndexOfFatigueLogic();
        $lists = $IndexOfFatigueL->select();
        foreach($lists as $list)
        {
            $IndexOfFatigueObj = new IndexOfFatigue($list['id']);
            $result[] = $IndexOfFatigueObj;
        }
        return $result;
    }

}

