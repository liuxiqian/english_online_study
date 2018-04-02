<?php

namespace Home\Model;

/**
 * 每日测试成绩
 */

use TestStudentTestPercentCourseView\Logic\TestStudentTestPercentCourseViewLogic;


class DayGrade extends Statistics
{
    protected $beforeTestGrade = NUll;
    protected $stageTestGrade = NUll;
    protected $groupTestGrade = NUll;
    private $studentCourseLists = NULL;//获取每天该学生学习课程的列表

    //获取某月每天的本类对象
    public function getCurrentMonthAllLists()
    {
        //根据本月天数实例本类对象
        $lists = array();
        for ($i = 1; $i <= $this->totalDays; $i++) {
            $beginTime = strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $i);
            $lists[] = new DayGrade($beginTime, $this->Student);
        }

        return $lists;
    }

    /**
     * 获取当月所学课程列表
     * @return array($Course) array(object)
     */
    public function getCurrentMonthStudyCourses()
    {
        $beginTime = strtotime($this->getYear() . '-' . $this->getMonth() . '-1');
        $endTime = $beginTime + strtotime($this->today . " +1 month");

        $map['student__id'] = $this->Student->getId();
        $map['time'] = array(array('egt', $beginTime), array('lt', $endTime));

        //由time找满足有效学习时间的time并求和
        $TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();
        $lists = $TestStudentTestPercentCourseViewL->where($map)->group('course__id')->select();
        // dump($lists);
        $course = array();
        foreach ($lists as $list) {
            # code...
            $course[] = new Course($list['course__id']);
        }

        return $course;
    }

    /**
     * 获取每天该该学生的课程的测试成绩
     * @param $Course object 课程对象
     * @return 当天 传入课程的最后一次测试成绩
     */
    public function getGrade(Course $Course)
    {
        //设定每天0点与24点
        $beginTime = strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $this->getDay());
        $endTime = $beginTime + 24 * 60 * 60;

        //设定查询条件
        $map = array();
        $map['student__id'] = $this->Student->getId();
        $map['course__id'] = $Course->getId();
        $map['time'] = array(array('egt', $beginTime), array('lt', $endTime));

        //取当天 传入课程的最后一次测试成绩
        $TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();
        $data = $TestStudentTestPercentCourseViewL->where($map)->order(array('time' => 'desc'))->find();

        return $data['grade'];
    }

    /**
     * 获取最低的学前成绩
     * @author xulinjie
     * @return int
     */
    public function getBeforeTestGrade()
    {
        if (is_null($this->beforeTestGrade)) {
            if ($this->isTomorrow()) {
                $this->beforeTestGrade = 0;
            } else if ($this->isToday()) {
                $this->beforeTestGrade = $this->_getBeforeTestGrade();
            } else {
                $this->beforeTestGrade = Cache::get(__CLASS__, __FUNCTION__, $this->cacheKey);
                if (FALSE === $this->beforeTestGrade) {
                    $this->beforeTestGrade = $this->_getBeforeTestGrade();
                    Cache::set(__CLASS__, __FUNCTION__, $this->cacheKey, $this->beforeTestGrade, 0);
                }
            }
        }

        return $this->beforeTestGrade;

    }

    private function _getBeforeTestGrade()
    {
        $min = 0;
        $max = 100;
        $beforeTest = 0;//学前测试成绩

        $lists = $this->getStudentCourseLists();
        foreach ($lists as $list) {
            if ((int)$list['type'] == 0) {
                if ((int)$list['grade'] == 100) {
                    $beforeTest = 100;
                }
                if ((int)$list['grade'] > $min && (int)$list['grade'] < $max) {
                    $max = (int)$list['grade'];
                }
            }
        }
        if ($max != 100) {
            $beforeTest = $max;
        }

        return $beforeTest;
    }

    /**
     * 获取每天该学生学习课程的列表
     * @param $Course object 课程对象
     * @return array
     */
    public function getStudentCourseLists()
    {
        if ($this->studentCourseLists === NULL) {
            //设定每天0点与24点
            $beginTime = strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $this->getDay());
            $endTime = $beginTime + 24 * 60 * 60;

            //设定查询条件
            $map = array();
            $map['student__id'] = $this->Student->getId();
            $map['time'] = array(array('egt', $beginTime), array('lt', $endTime));

            //取当天 传入课程的最后一次测试成绩
            $TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();
            $this->studentCourseLists = $TestStudentTestPercentCourseViewL->where($map)->select();
        }

        return $this->studentCourseLists;
    }

    /**
     * 获取最高组测试成绩
     * @author xulinjie
     * @return int
     */
    public function getGroupTestGrade()
    {
        if (is_null($this->groupTestGrade)) {
            if ($this->isTomorrow()) {
                $this->groupTestGrade = 0;
            } else if ($this->isToday()) {
                $this->groupTestGrade = $this->_getGroupTestGrade();
            } else {
                $this->groupTestGrade = Cache::get(__CLASS__, __FUNCTION__, $this->cacheKey);
                if (FALSE === $this->groupTestGrade) {
                    $this->groupTestGrade = $this->_getGroupTestGrade();
                    Cache::set(__CLASS__, __FUNCTION__, $this->cacheKey, $this->groupTestGrade, 0);
                }
            }
        }

        return $this->groupTestGrade;
    }

    /**
     * 获取最高阶段测试成绩
     * @author xulinjie
     * @return int
     */
    public function getStageTestGrade()
    {
        if (NULL === $this->stageTestGrade) {
            if ($this->isTomorrow()) {
                $this->stageTestGrade = 0;
            } else if ($this->isToday()) {
                $this->stageTestGrade = $this->_getStageTestGrade();
            } else {
                $this->stageTestGrade = Cache::get(__CLASS__, __FUNCTION__, $this->cacheKey);
                if (FALSE === $this->stageTestGrade) {
                    $this->stageTestGrade = $this->_getStageTestGrade();
                    Cache::set(__CLASS__, __FUNCTION__, $this->cacheKey, $this->stageTestGrade, 0);
                }
            }
        }

        return $this->stageTestGrade;
    }

    private function _getStageTestGrade()
    {
        $stageTest = 0;//阶段测试

        $lists = $this->getStudentCourseLists();
        foreach ($lists as $list) {
            if ((int)$list['type'] == 2 && ((int)$list['grade'] > $stageTest)) {
                $stageTest = (int)$list['grade'];
            }
        }

        return $stageTest;
    }

    private function _getGroupTestGrade()
    {
        $groupTest = 0;//组测试

        $lists = $this->getStudentCourseLists();
        foreach ($lists as $list) {
            if ((int)$list['type'] == 1 && ((int)$list['grade'] > $groupTest)) {
                $groupTest = (int)$list['grade'];
            }
        }

        return $groupTest;
    }
}