<?php
/**
* 
进度查询
*/
namespace Admin\Controller;

use Admin\Model\Schedule\BaseModel;
use Admin\Model\Schedule\DetailModel;
use Student\Logic\StudentLogic;   

use Home\Model\Student;         // 学生
use Home\Model\Course;          // 课程
use Home\Model\DayStudyTime;    // 每日学习时长
use Home\Model\TestRecord;      // 测试记录

class ScheduleController extends AdminController
{
     public function indexAction()
    {
        //获取当前登录用户的信息
        $user = $this->getUser();

        $M = new BaseModel();
        $M->setUserId($user['id']);

        $this->assign("M",$M);
        $this->display();
        return;
    }

    /**
     * 查看学生学习详情
     * @return   html                   
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-10T10:19:21+0800
     */
    public function detailAction()
    {
        $studentId = I('get.id');
        $Student = new Student($studentId);
        if (0 === $Student->getId()) {
            return $this->error('传入的学生信息有误');
        }

        $detailModel = new DetailModel;
        $detailModel->setStudent($Student);
        $this->assign('detailModel',$detailModel);
        $this->display();
    }

    //冻结学生
    public function frozenAction()
    {

        //获取学生id修改该学生的状态
        $studentId = I('get.id');
        $M = new BaseModel();
        $list = $M->getStudentByStudentId($studentId);
        if ($list['status'] == 0) {
            $list['status'] = 1;
        }
        else{
            $list['status'] = 0;
        }
        //更新学生信息
        $StudentL = new StudentLogic();
        if ($StudentL->saveList($list) === false)
        {
            $this->error("操作失败：" . $StudentL->getError(), U('index?id=', I('get.')));
            return;
        } 
        else
        {
            $this->success('操作成功', U('index?id=', I('get.')));
            return;
        }   
    }

    //学习记录查看
    public function studyrecordAction()
    {
        $courses = array();

        // 实例化学生 课程
        $studentId = (int)I('get.id');
        $Student = new Student($studentId);
        if ($Student->getId() == 0)
        {
            E('传入的参数不正确：未获取到正确的学生信息');
        }

        $courseId = (int)I('get.course_id');
        $Course = new Course($courseId);
        if ($Course->getId() == 0)
        {
            $courses = $Student->getAllCourses();
        } else {
            array_push($courses, $Course);
        }
        

        $beginTime = I('get.begin_time') === '' ? strtotime(date("Ymd") . '-7 day') : strtotime(I('get.begin_time'));
        $endTime = I('get.end_time') === '' ? time() : strtotime(I('get.end_time'));

        $dayStudyTimes = DayStudyTime::getLists($Student, $beginTime, $endTime);
        $this->assign('dayStudyTimes', $dayStudyTimes);
        $this->assign('beginTime', $beginTime);
        $this->assign('endTime', $endTime);
        $this->assign('courses', $courses);
        $this->assign('Student', $Student);
        $this->display('studyrecord');
    }

    //测试记录查看
    public function testrecordAction()
    {
        //取学生id
        $studentId = (int)I('get.id');
        //取课程id
        $courseId = (int)I('get.course_id');
        //实例化课程学生
        $Course = new Course($courseId);
        $Student = new Student($studentId);

        $beginTime = I('get.begin_time') === '' ? strtotime(date("Ymd") . '-7 day') : strtotime(I('get.begin_time'));
        $endTime = I('get.end_time') === '' ? time() : strtotime(I('get.end_time') . '+1 day -1 second');

        $map = array();
        if ($courseId)
        {
            $map['course__id'] = $courseId;
        }
        
        $map['student__id'] = $studentId;

        $tests = TestRecord::getByBeginTimeEndTimeStudentCourse($beginTime, $endTime, $Student, $Course);

        //传给V层
        $this->assign('Student', $Student);
        $this->assign('beginTime', $beginTime);
        $this->assign('endTime', $endTime);
        $this->assign('tests',$tests);
        $this->display('testrecord');
    }
}