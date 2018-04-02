<?php

namespace Login\Logic;

use Login\Model\LoginModel;

class LoginLogic extends LoginModel
{
	/**
     * 获取某个学生登陆的总次数（已完成）
     * @param  int $studentId 学生ID
     * @return int
     */
    public function getCountByStudentId($studentId)
    {
        $map['student_id'] = (int)($studentId);
        $LoginL = new LoginLogic();
        return $LoginL->where($map)->count();
    } 

    /**
     * 获取某个学生最后一次的登陆时间（已完成）
     * @param  int $studentId 学生ID
     * @return time 时间戳
     */
    public function getLastLoginTimeByStudentId($studentId)
    {
        $map['student_id'] = (int)($studentId);
        $list = $this->where($map)->order('time desc')->find();
        return $list['time'];
    }

    /**
     * 获取某个学生最后一次登陆的登陆ID(已完成)
     * @return int 
     */
    public function getLastLoginIdByStudent($studentId)
    {
        $map['student_id'] = (int)($studentId);
        $LoginL = new LoginLogic();
        $list = $LoginL->where($map)->order('time desc')->find();
        return $list['id'];
    }

    /**
     * 获取某个学生首次登陆的时间(已完成)
     * @return time 时间戳
     */
    public function getFirstLoginTimeByStudentId($studentId)
    {
        $map['student_id'] = (int)$studentId;
        $LoginL = new LoginLogic();
        $list = $LoginL->where($map)->order('time asc')->find();
        return $list['time'];
    }

    
    
    /**
     * 获取某个学生最后一次登陆的登陆记录（已完成）
     * @param  int $studentId 学生ID
     * @return list 一维数组或null
     */
    public function getLastListByStudentId($studentId)
    {
        $map['student_id'] = (int)$studentId;
        $LoginL = new LoginLogic();
        return $LoginL->where($map)->order('time desc')->find();
    }
}