<?php
/*
进度查询
魏静云
 */
namespace Admin\Model\Schedule;

use Student\Logic\StudentLogic;   //学生
use Klass\Logic\KlassLogic; //班级
use Login\Logic\LoginLogic;//登录
use TestStudentTestPercentCourseView\Logic\TestStudentTestPercentCourseViewLogic;//测试 学生 测试百分比 课程视图
use WordProgressLoginView\Logic\WordProgressLoginViewLogic;//学生单词进度
use KlassCourseStudentView\Logic\KlassCourseStudentViewLogic;//课程
use UserDepartmentPostView\Logic\UserDepartmentPostViewLogic;  //用户区域岗位视图，用来设置当前登录用户
use UserKlassStudentView\Logic\UserKlassStudentViewLogic;//用户班级学生视图，用来取学生列表、班级列表
use KlassUserView\Logic\KlassUserViewLogic;//取对应登录用户的可查的班级


class BaseModel
{
    protected $StudentL                             = null;
    protected $user                                 = null;
    protected $KlassL                               = null;
    protected $LoginL                               = null;//获取学生登录时间，登陆次数
    protected $TestStudentTestPercentCourseViewL    = null;//为获取学生进度
    protected $WordProgressLoginViewL               = null;//为获取上次用时
    protected $KlassCourseStudentViewL              = null;//为获取剩余单词
    protected $UserDepartmentPostViewL              = null;      //用户区域岗位视图,为设置当前登录用户的权限
    protected $UserKlassStudentViewL = null;        //用户班级学生视图,为取对应登录用户的可查的学生
    protected $KlassUserViewLogicL                  = null;//取对应登录用户的可查的班级,取对应登录用户的可查的班级
    public $totalCount                              = 0;        //数据总数



    public function __construct()
    {
        $this->StudentL = new StudentLogic();
        $this->KlassL = new KlassLogic();
        $this->LoginL = new LoginLogic();
        $this->TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();
        $this->WordProgressLoginViewL = new WordProgressLoginViewLogic();
        $this->KlassCourseStudentViewL = new KlassCourseStudentViewLogic();
        $this->UserDepartmentPostViewL = new UserDepartmentPostViewLogic();
        $this->UserKlassStudentViewL = new UserKlassStudentViewLogic();
        $this->KlassUserViewL = new KlassUserViewLogic();

        $klass_id = (int)I("get.klass_id"); 
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

    public function getUser()
    {
        return $this->user;
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
            dump($userId);
        }
        $map['user_id'] = $userId;
        $data = $this->KlassUserViewL->where($map)->select();
        return $data;
    }

    //获取当前用户所在部门下的 班级列表
    public function getDepartmentLists()
    {
        $map['department_id'] = $this->user['department_id'];
        return $this->KlassUserViewL->where($map)->select();
    }

    //获取班级视图下的 班级列表。
    public function getLists()
    {
        return $this->KlassUserViewL->select();
        
    }


    //获取当前登录用户应获得的班级列表
    public function getKlasses()
    {
        if ($this->isSon() === 1)
        {
            if($this->isAdmin() === 1)
            {
                dump($this->user);
                return $this->getDepartmentLists();
            }
            else
            {
                return $this->getListsByUserId();
            }
        }
        else
        {
            return $this->getLists();
        }
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

    /**
     * 根据学生id获取学生信息
     * @param int 学生id
     * @return array() 学生信息
     */
    public function getStudentByStudentId($studentId)
    {
        $map['id'] = $studentId;
        $data = $this->StudentL->where($map)->find();
        return $data;
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

    /**
     * 获取学生所在的班级
     * @param  int $klassId 班级id
     * @return string 班级名称
     */
    public function getKlassByKlassId($klassId)
    {
        $map = array();
        $map['id'] = (int)$klassId;
        $Klass = $this->KlassL->where($map)->find();
        return $Klass['name'];
    }


    /**
     * 获取学生登录次数
     * @param int $studentId 学生id
     * @return int 登录次数
     */
    public function getCountByStudentId($studentId)
    {
        $map = array();
        $map['student_id'] = $studentId;
        return $this->LoginL->where($map)->count();
    }

    /**
     * 获取学生首次登陆时间
     * @param int $studentId 学生id
     * @return int 首次登陆时间
     */
    public function getFristLoginByStudentId($studentId)
    {
        $map = array();
        $map['student_id'] = $studentId;
        $time = $this->LoginL->where($map)->order('time asc')->limit(1)->select();
        if ($time[0]['time'] === null) {
            return 0;        
        }
        else{
            return $time[0]['time'];
        }
        
    }

    /**
     * 获取学生上次登陆时间
     * @param int $studentId 学生id
     * @return int 上次登陆时间
     */
    public function getLastLoginTimeByStudentId($studentId)
    {
        $map = array();
        $map['student_id'] = $studentId; 
        $time = $this->LoginL->where($map)->order('time desc')->limit(1)->select();
        if ($time[0]['time'] === null) {
            return 0;        
        }
        else{
            return $time[0]['time'];
        }
    }

    /**
     * 获取上次登录id
     * @param int $studentId 学生id
     * @return int 上次登录id
     */
    public function getLastLoginIdByStudentId($studentId)
    {
        $map = array();
        $map['student_id'] = $studentId;
        $time = $this->LoginL->where($map)->order('time desc')->limit(1)->select();
        if ($time[0]['time'] === null) {
            return 0;        
        }
        else{
            return $time[0]['id'];
        }
    }

    /**
     * 获取上次用时
     *@param int $studentId 学生id
     *@return int 上次用时
     */
    public function getTimeCostByStudentIdLoginId($studentId,$loginId)
    {
        return $this->WordProgressLoginViewL->getTimeCostByStudentIdLoginId($studentId,$loginId);
    }

    /**
     * 获取累计用时
     * @param int $studentId 学生id
     * @return int 累计用时
     */
    public function getTotalTimeCostByStudentId($studentId)
    {
       return $this->WordProgressLoginViewL->getTotalTimeCostByStudentId($studentId);
    }

    //获取学生进度
    public function getProgressByStudentId($studentId)
    {
        return $this->TestStudentTestPercentCourseViewL->getProgressByStudentId($studentId);
    }

    /**
     * 获取学生新学单词个数
     * @param int $studentId 学生id
     * @return int 新学单词个数
     */
    public function getNewWordCountByStudentId($studentId)
    {
        return $this->WordProgressLoginViewL->getNewWordCountByStudentId($studentId);
    }

    /**
     * 获取某个学生复习的单词总数
     * @param  int $studentId 学生ID
     * @return INT            
     */
    public function getOldWordCountByStudentId($studentId)
    {
        return $this->WordProgressLoginViewL->getOldWordCountByStudentId($studentId);
    }

    /**
     * 获取剩余单词
     * @param int $studentId 学生id
     * @return  int 剩余单词个数
     */
    public function getSurplusWordByStudentId($studentId)
    {
        $all = $this->KlassCourseStudentViewL->getAllWordNumByStudentId($studentId);
        // dump($all);
        $newStudy = $this->WordProgressLoginViewL->getNewWordCountByStudentId($studentId);
        // dump($newStudy);
        if ($all-$newStudy > 0) {
            $surplusWordCount = $all-$newStudy;
        }
        else{
            $surplusWordCount = 0;
        }
        return $surplusWordCount;
    }
}