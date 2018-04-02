<?php

namespace Home\Model;


use StudentCourseProcess\Logic\StudentCourseProcessLogic;

class StudentCourseProcess
{
    private $Student = NULL;
    private $Course = NULL;
    private $reviewCount = NULL; // 重习个数
    private $studyCount = NULL;    // 新学个数


    public function __construct(Student $student, Course $course) {
        $this->Course = $course;
        $this->Student = $student;
    }


    public function getStudent()
    {
        if (NULL === $this->Student) {
            if (NULL !== $this->studentId) {
                $this->Student = new Student($this->studentId);
            }
        }

        return $this->Student;
    }

    public function setStudent(Student $student)
    {
        $this->Student = $student;
    }

    public function getCourse()
    {
        if (NULL === $this->Course) {
            if (NULL !== $this->courseId) {
                $this->Course = new Student($this->studentId);
            }
        }

        return $this->Course;
    }

    public function setCourse(Course $course)
    {
        $this->Course = $course;
    }

    /**
     * @return int|null
     * Create by panjie@yunzhiclub.com
     * 获取复习数
     */
    public function getReviewCount() {
        if (is_null($this->reviewCount)) {
            $this->getThisList();
        }

        return $this->reviewCount;
    }

    public function getStudyCount() {
        if (is_null($this->studyCount)) {
            $this->getThisList();
        }

        return $this->studyCount;
    }

    /**
     * Create by panjie@yunzhiclub.com
     * 获取本对象的数据
     */
    private function getThisList() {
        // 查询表并存数
        $StudentCourseProcessL = new StudentCourseProcessLogic();
        $map = [];
        $map['course_id'] = $this->getCourseId();
        $map['student_id'] = $this->getStudentId();

        $list = $StudentCourseProcessL->where($map)->find();
        if (FALSE !== $list) {
            $this->reviewCount = $list['review_count'];
            $this->studyCount = $list['study_count'];
        } else {
            $this->reviewCount = 0;
            $this->studyCount = 0;
        }

        unset($StudentCourseProcessL);
        unset($list);
        unset($map);
    }
}