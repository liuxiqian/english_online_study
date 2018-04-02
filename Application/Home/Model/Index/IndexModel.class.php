<?php
/**
 * 前台小M
 * xulinjie
 * 2016.04.25
 */
namespace Home\Model\Index;

use KlassCourseStudentView\Logic\KlassCourseStudentViewLogic;

class indexModel{
    protected $user                     = array();
    protected $KlassCourseStudentViewL  = null;

    public function __construct(){

        $this->KlassCourseStudentViewL = new KlassCourseStudentViewLogic();
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getUserName()
    {
        return $this->user['name'];
    }

    /**
     * 取某个学生共有多少门课程
     * xulinjie
     */
    public function getCoursesByStudentId($id)
    {
        return $this->KlassCourseStudentViewL->where(array("student__id" => $id))->count();
    }

    
}