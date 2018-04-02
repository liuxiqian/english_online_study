<?php
namespace Admin\Model\Test;

use UserDepartmentPostView\Logic\UserDepartmentPostViewLogic;  //用户区域岗位视图，用来设置当前登录用户
use UserKlassStudentView\Logic\UserKlassStudentViewLogic;//用户班级学生视图，用来取学生列表、班级列表
use TestStudentTestPercentCourseView\Logic\TestStudentTestPercentCourseViewLogic;//测试学生测试百分比课程视图，用来取测试信息
use WordProgressLoginView\Logic\WordProgressLoginViewLogic;//单词进度登录视图，用来取学习单词情况
use WordProgressLoginWordCourseView\Logic\WordProgressLoginWordCourseViewLogic;//单词进度登陆单词课程视图，用来取学习单词过程中学习的课程
/**
* 测试页面小模型
*/
class BaseModel
{
    protected $user;                                //当前登录用户信息
    protected $UserDepartmentPostViewL = null;      //用户区域岗位视图
    protected $UserKlassStudentViewL = null;        //用户班级学生视图
    protected $TestStudentTestPercentCourseViewL = null;//测试学生测试百分比课程视图
    protected $WordProgressLoginViewL = null;       //单词进度登录视图
    protected $WordProgressLoginWordCourseViewL = null;//单词进度登陆单词课程视图，用来取学习单词过程中学习的课程
    protected $beginTime = 0;                       //某天0点时间戳
    protected $endTime = 0;                         //24点时间戳
    public $totalCount                              = 0;        //数据总数

    public function __construct()
    {
        $this->UserDepartmentPostViewL = new UserDepartmentPostViewLogic();
        $this->UserKlassStudentViewL = new UserKlassStudentViewLogic();
        $this->TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();
        $this->WordProgressLoginViewL = new WordProgressLoginViewLogic();
        $this->WordProgressLoginWordCourseViewL = new WordProgressLoginWordCourseViewLogic();

        $klass_id = (int)I("get.klass_id");         //获取页面上班级id
        $time = strtotime(I('get.time'))?strtotime(I('get.time')):strtotime(date('Y-m-d'));                             //获取页面上时间戳
        $this->beginTime = $time;
        $this->endTime = $time+24*60*60;

        if ($klass_id)
        {
            $map['klass__id'] = $klass_id;
            $this->UserKlassStudentViewL->addMaps($map);
        }
        
    }

    //设置userID，目的是通过USERID来获取用户视图下我们有用的信息
    public function setUserId($userId)
    {
        //获取班级用户视图下的全部信息
        $map['id'] = (int)$userId;
        $this->user = $this->UserDepartmentPostViewL->where($map)->find();
        return;
    }


    //获取当前用户所处的区域，是否子区域。
    //是子区载返回 1 ， 非子区域返回 0
    public function isSon()
    {
        if((int)$this->user['department__is_son'] === 0)
            return 0;
        else
            return 1;
    }

    //判断当前用户是否为管理员 
    public function isAdmin()
    {
        if((int)$this->user['post__is_admin'] === 1)
            return 1;
        else
            return 0;
    }

    //获取当前用户的 班级列表
    public function getListsByUserId($userId = null)
    {
        if ($userId === null)
        {
            $userId = $this->user['id'];
        }
        $map['user__id'] = $userId;
        return $this->UserKlassStudentViewL->where($map)->group("klass__id")->select();
    }

    //获取当前用户所在部门下的 班级列表
    public function getDepartmentLists()
    {
        $map['department__id'] = $this->user['department_id'];
        return $this->UserKlassStudentViewL->where($map)->group("klass__id")->select();
        
    }

    //获取班级视图下的 班级列表。
    public function getLists()
    {
        return $this->UserKlassStudentViewL->group("klass__id")->select();
    }

    //获取当前登录用户应获得的班级列表
    public function getKlasses()
    {
        if ($this->isSon() === 1)
        {
            if($this->isAdmin() === 1)
            {
                return $this->getDepartmentLists();
            }
            else
                return $this->getListsByUserId();
        }
        else
            return $this->getLists();
    }

    //获取当前用户对应的学生列表
    public function getStudentsByUserId($userId = null)
    {
        if ($userId === null)
        {
            $userId = $this->user['id'];
        }
        $map['user__id'] = $userId;
        $datas = $this->UserKlassStudentViewL->addMaps($map)->getLists();
        $this->totalCount = $this->UserKlassStudentViewL->getTotalCount();
        return $datas;
    }


    //获取当前区域所对应的学生列表
    public function getDepartmentStudents()
    {
        $map['department__id'] = $this->user['department_id'];
        $datas = $this->UserKlassStudentViewL->addMaps($map)->getLists();
        $this->totalCount = $this->UserKlassStudentViewL->getTotalCount();
        return $datas;
    }

    public function getAllStudents()
    {
        $datas = $this->UserKlassStudentViewL->getLists();
        $this->totalCount = $this->UserKlassStudentViewL->getTotalCount();
        return $datas;
    }

    //页面输出学生列表
    public function getStudents()
    {
        if ($this->isSon() === 1)
        {
            if($this->isAdmin() ===1)
            {
                return $this->getDepartmentStudents();
            }
            else
            {
                return $this->getStudentsByUserId();
            }
        }
        else
        {
            return $this->getAllStudents();
        }
    }

    //获取学生某天的测试次数
    public function getTestCountByStudentId($studentId)
    {
        $map['student__id'] = $studentId;
        //根据传入时间进行where条件查询

        $map['time'] = array(array('egt',$this->beginTime),array('lt',$this->endTime));
        return $this->TestStudentTestPercentCourseViewL->where($map)->count();
    }

    //获取学前成绩
    public function getLearnBeforeTestGradeByStudentId($studentId)
    {
        //取符合条件的测试
        $map['student__id'] = $studentId;
        $map['time'] = array(array('egt',$this->beginTime),array('lt',$this->endTime));
        $datas = $this->TestStudentTestPercentCourseViewL->where($map)->group("course__id")->select();
        if (empty($datas))
        {
            return 0;
        }
        else
        {
            //根据测试的课程id取该门课程的第一次测试
            $map = array();
            $map['student__id'] = $studentId;
            foreach ($datas as $key => $value) 
            {
                $map['course__id'] = $value['course__id'];
                $data = $this->TestStudentTestPercentCourseViewL->where($map)->order(array("time" => "asc"))->find();
                $grade[] = $data['grade'];
            }
            //返回所测试的课程的  第一次测试的  最低成绩
            return min($grade);
        }
    }

    //获取某天测试的学后成绩（测试中最大成绩）
    public function getLearnAfterTestGradeByTimeStudentId($studentId)
    {
        $map['student__id'] = $studentId;
        $map['time'] = array(array('egt',$this->beginTime),array('lt',$this->endTime));
        $data = $this->TestStudentTestPercentCourseViewL->where($map)->order(array('grade'=>'desc'))->find();
        if (empty($data))
        {
            return 0;
        }
        return $data['grade'];
    }

    //获取新学单词
    public function getNewWordsByStudentId($studentId)
    {
        $map['student_id'] = $studentId;
        $map['time'] = array(array('egt',$this->beginTime),array('lt',$this->endTime));
        $map['is_new'] = 1;
        return $this->WordProgressLoginViewL->where($map)->count();
    }

    public function getOldWordsByStudentId($studentId)
    {
        $map['student_id'] = $studentId;
        $map['time'] = array(array('egt',$this->beginTime),array('lt',$this->endTime));
        $map['is_new'] = 0;
        return $this->WordProgressLoginViewL->where($map)->count();
    }

    /**
     * 获取该学生的测试课程名称
     * @param int 学生id
     * @return array()    课程名称
     */
    public function getTestCourseTitleByStudentId($studentId)
    {
        //对进行测试的课程进行查询
        $map = array();
        $map['student__id'] = $studentId;
        $map['time'] = array(array('egt',$this->beginTime),array('lt',$this->endTime));//设置时间限制
        $test = $this->TestStudentTestPercentCourseViewL->where($map)->group("course__title")->select();
        $testCourse = array();//初始化存测试课程的数组
        foreach ($test as $testC) {
            $testCourse[] = $testC['course__title'];
        }
        unset($map['student__id']);//转换查询视图，unset一下无用查询条件

        //对学习单词过程中学习到的课程进行查询
        $map['login__student_id'] = $studentId;
        $wordProgress = $this->WordProgressLoginWordCourseViewL->where($map)->group("course__title")->select();
        $wordProgressCourse = array();//初始化存学习单词过程中的课程的数组
        foreach ($wordProgress as $wordP) {
            $wordProgressCourse[] = $wordP['course__title'];
        }
        $diff = array_diff($testCourse,$wordProgressCourse);
        return array_merge($diff,$wordProgressCourse);
    }

}