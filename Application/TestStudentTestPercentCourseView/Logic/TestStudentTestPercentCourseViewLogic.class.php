<?php
/**
 * 测试学生课程测试百分比视图
 * 魏静云
 */

namespace TestStudentTestPercentCourseView\Logic;

use TestStudentTestPercentCourseView\Model\TestStudentTestPercentCourseViewModel;
use KlassCourseStudentView\Logic\KlassCourseStudentViewLogic;       //班级 课程 学生视图
use Word\Logic\WordLogic;                                           //词汇视图

class TestStudentTestPercentCourseViewLogic extends TestStudentTestPercentCourseViewModel
{
    private $grade = 80; //通过测试的成绩

    public function __construct()
    {
        $this->grade = C("YUNZHI_GRADE") ? C("YUNZHI_GRADE") : $this->grade;
        $this->KlassCourseStudentViewL = new KlassCourseStudentViewLogic();
        $this->WordL = new WordLogic;
        parent::__construct();
    }

    /**
     * 获取 某学生 的整体学习进度
     * @param  int $studentId 学生ID
     * @return int  学习进度（百分比） 40% 则返回 40
     */
    public function getProgressByStudentId($studentId)
    {
        if ((int)C('YUNZHI_GRADE') !== 0) $this->grade = C("YUNZHI_GRADE");

        //1.取该学生的每门课程的所有测试成绩大于等于 通过值 的，测试百分比表中百分比最大的
        $lists = $this->where(array('student__id' =>$studentId))->select();
        // dump($lists);

        //取成绩大于80的
        foreach ($lists as $key => $value) {
            if ((int)$value['grade'] < $this->grade) {
                unset($lists[$key]);
            }
        }
        // dump($lists);

        //按课程ID进行分组
        $lists = group_by_key($lists, "course__id");
        // dump($lists);

        //求出当前二维数组中，进度最大的一组数组。
        $maxPercents = array();
        foreach ($lists as $key => $data) {
            $maxPercents[$key] = $this->_getMaxListByKey($data, 'percent');
        }
        // dump($maxPercents);

        //取出当前学生的所有课程 
        $allCourses = $this->KlassCourseStudentViewL->where(array('student__id' =>$studentId))->select();
        //2.取每门课程的的单词总数countword
        $sum = 0;
        $studiedNum = 0;
        foreach ($allCourses as $key => $course) {
            $courseId = $course['course_id'];
            $num = $this->_getCountByCourseId($courseId);
            $sum += $num;
        }
        foreach ($maxPercents as $key => $value) {
            $percent = (int)$value['percent'];
            $courseId = $value['course__id'];
            $num = $this->_getCountByCourseId($courseId);
            $studiedNum += $percent * $num /100;
        }

        return floor($studiedNum * 100/$sum+0.5);
    }

    /**
     * 取出二组数组中 key值最大的一条数组并返回
     * @param   $lists 
     * @param  键值 $key   
     * @return list        
     * $lists = array(
     *     array("id"=>1, "value"=>"80");
     *     array("id"=>2, "value"=>"90");
     *     array("id"=>3, "value"=>"70");
     * );
     * $key = "value";
     * return array("id"=>2, value=>"90");
     */
    protected function _getMaxListByKey($lists, $key)
    {
        $temp = $lists[0];
        foreach($lists as $list)
        {
            if ($list[$key] > $temp[$key])
            {
                $temp = $list;
            }
        }
        return $temp;
    }

     /**
     * 通过课程ID，获取当前课程的单词总数
     * @param  int $courseId 
     * @return  单词总数
     */
    protected function _getCountByCourseId($courseId)
    {
        $map = array();
        $map['course_id'] = $courseId;
        return $this->WordL->where($map)->count();
    }

    public function getGrade()
    {
       return $this->grade;
    }
}