<?php
namespace Home\Model;
use Test\Model\TestModel;   // 测试记录
use TestTestPercentView\Model\TestTestPercentViewModel; // 测试 测试百分比
/**
 * 测试记录
 */
class TestRecord
{
    private $id = 0;
    private $time = 0;
    private $testPercentId = 0;

    public function __construct($id)
    {
        $TestModel = new TestModel;
        $map = array();
        $map['id'] = (int)$id;
        $TestModel = new TestModel;
        $list = $TestModel->where($map)->find();
        if (null !== $list)
        {
            $this->id = (int)$id;
            $this->time = $list['time'];
            $this->grade = $list['grade'];
            $this->studentId = $list['student_id'];
            $this->testPercentId = $list['test_percent_id'];
        }
        unset($TestModel);
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function getTime()
    {
        return (int)$this->time;
    }

    public function getGrade()
    {
        return (int)$this->grade;
    }

    public function getStudentId()
    {
        return (int)$this->studentId;
    }

    public function getTestPercentId()
    {
        return (int)$this->testPercentId;
    }

    public function getTestPercent()
    {
        return $this->getTest();
    }

    public function getTest()
    {
        if (null === $this->Test)
        {
            $this->Test = new Test($this->getTestPercentId());
        }

        return $this->Test;
    }

    public function getStudent()
    {
        if (null === $this->Student)
        {
            $this->Student = new Student($this->getStudentId());
        }

        return $this->Student;
    }   

    /**
     * 获取某学生的某个测试成绩是否达标
     * @param    int                   $testPercentId 测试ID
     * @param    Student                  &$Student      学生
     * @return   达标true 未达标 false                                 
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-11T10:58:36+0800
     */
    static public function isPassed($testPercentId, $type = 0, Student &$Student)
    {
        // 查找所有测试记录
        $map = [];
        $map['test_percent_id']     = (int)$testPercentId;
        $map['student_id']          = $Student->getId();
        $order = array('grade' => 'desc');
        $TestM = new TestModel;
        $list = $TestM->field('grade')->where($map)->order($order)->find();
        unset($TestM);


        // 没有测试记录，说明学生还没有测试过
        if (null === $list) {
            return false;

        // 有测试记录，则判断最高的这条测试记录，是否通过了测试。（如果为前测，则直接认为通过了测试）
        } else if (($list['grade'] >= C('YUNZHI_GRADE')) || (0 === $type)) {
            return true;
        }

        return false;
    }

    static public function getByBeginTimeEndTimeStudentCourse($beginTime, $endTime, &$Student, &$Course)
    {
        if (!($Student instanceof Student))
        {
            E('接收到一个非Student的变量类型');
        }

        if (!($Course instanceof Course))
        {
            E('接收到一个非Course的变量类型');
        }

        // 互换起始结束时间
        if ($beginTime > $endTime)
        {
            $temp = $beginTime;
            $beginTime = $endTime;
            $endTime = $temp;
        }

        $map = array();

        // 传入课程，则将课程ID做为查询条件
        if (0 != $Course->getId())
        {
            $map['test_percent__course_id'] = $Course->getId();
        }  

        // 加入时间范围及学生
        $map['time'] = array(array('egt', $beginTime), array('lt', $endTime));
        $map['student_id'] = $Student->getId();
        $TestTestPercentViewM = new TestTestPercentViewModel;
        $lists = $TestTestPercentViewM->field('id')->order('time desc')->where($map)->select();

        $result = array();
        foreach ($lists as $list) {
            $result[] = new TestRecord($list['id']);
        }

        return $result;
    }
}