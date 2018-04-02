<?php
namespace Home\Model;

/**
* 测试成绩类
*/
class TestScore
{
    private $Student = null;    //学生类
    private $Course  = null;    //班级类
    private $time    = 0;       //测试时间
    private $score   = 0;       //测试成绩
    private $isPass  = null;    //是否通过 是返回true 否返回false

    function __construct($Student,$Course)
    {
        $this->Student = $Student;
        $this->Course = $Course;

    }

    /**
    * 获取测试时间
    * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * 获取测试成绩
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * 是否通过测试
     * @return bool 通过返回true 未通过返回false
     */
    public function getIsPass()
    {
        return $this->isPass;
    }
}
