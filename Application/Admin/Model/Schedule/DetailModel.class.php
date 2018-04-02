<?php
namespace Admin\Model\Schedule;

use Home\Model\Model;
use Home\Model\Schedule;
use Home\Model\Student;             // 学生
use Home\Model\Course;              // 课程
use Home\Model\StudentCourse;       // 学生课程

/**
 * 进度查询 进度详情
 */
class DetailModel extends Model
{
    private $student = null;

    /**
     * 设置学生
     * @param   Student  $student 学生
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-10T10:20:12+0800
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

    public function getStudent() {
        return $this->student;
    }

    public function getSchedules() {
        return Schedule::getListsByStudentId($this->student->getId());
    }
}