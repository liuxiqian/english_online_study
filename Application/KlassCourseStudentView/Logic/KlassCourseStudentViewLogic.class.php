<?php
namespace KlassCourseStudentView\Logic;

use KlassCourseStudentView\Model\KlassCourseStudentViewModel;
use Word\Logic\WordLogic;

/**
* 班级课程学生模块
* 魏静云
*/
class KlassCourseStudentViewLogic extends KlassCourseStudentViewModel
{
    /**
     * 获取学生的单词总数
     */
    public function getAllWordNumByStudentId($studentId)
    {
        //取出当前学生的所有课程 
        $map = array();
        $map['student__id'] = $studentId;
        $KlassCourseStudentViewL = new KlassCourseStudentViewLogic();
        $allCourses = $KlassCourseStudentViewL->where($map)->select();
        
        //获取课程的单词总数  
        $sum = 0;
        // dump($allCourses);
        foreach ($allCourses as $key => $value)
        {
            $sum += $KlassCourseStudentViewL->getWordCountByCourseId($value['course_id']);

        }
        return $sum;
    }

    //取单词总数
    public function getWordCountByCourseId($courseId)
    {
        $WordL = new WordLogic();
        $map['course_id'] = (int)$courseId;
        return $WordL->where($map)->count();
    }
}