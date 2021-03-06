<?php
/*
学生管理
魏静云
 */
namespace Admin\Model\Student;

use Admin\Controller\NotesController;
use Student\Logic\StudentLogic;   //学生
use TestStudentTestPercentCourseView\Logic\TestStudentTestPercentCourseViewLogic;  //测试 学生 测试百分比 课程视图
use CardStudentCardBatchView\Logic\CardStudentCardBatchViewLogic;//卡密 学生 批次视图
use UserDepartmentPostView\Logic\UserDepartmentPostViewLogic;  //用户区域岗位视图，用来设置当前登录用户
use UserKlassStudentView\Logic\UserKlassStudentViewLogic;//用户班级学生视图，用来取学生列表
use Card\Logic\CardLogic;//卡密表，获取学生卡密信息
use KlassUserView\Logic\KlassUserViewLogic;//班级用户视图，为取班级列表

class BaseModel
{
    protected $user                                 = array();  //当前用户
    protected $StudentL                             = null;//学生
    protected $TestStudentTestPercentCourseViewL    = null;//测试 学生 测试百分比 课程视图
    protected $CardStudentCardBatchViewL            = null;//卡密 学生 批次视图
    protected $UserDepartmentPostViewL              = null;      //用户区域岗位视图,用来设置当前登录用户
    protected $UserKlassStudentViewL = null;        //用户班级学生视图,用来取学生列表
    protected $CardL                                = null;//卡密表，获取学生卡密信息
    protected $KlassUserViewL                       = null;//为取班级列表
    public $totalCount                              = 0;        //总数


    public function __construct()
    {
        $this->StudentL = new StudentLogic();
        $this->TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();
        $this->CardStudentCardBatchViewL = new CardStudentCardBatchViewLogic();
        $this->UserDepartmentPostViewL = new UserDepartmentPostViewLogic();
        $this->UserKlassStudentViewL = new UserKlassStudentViewLogic();
        $this->CardL = new CardLogic();
        $this->KlassUserViewL = new KlassUserViewLogic();
    }


    //设置userID，目的是通过USERID来获取用户视图下我们有用的信息
    public function setUserId($userId)
    {
        //获取班级用户视图下的全部信息
        $map['id'] = (int)$userId;
        $this->user = $this->UserDepartmentPostViewL->where($map)->find();
        return;
    }

    //获取当前登录用户的信息
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

    //判断当前用户是否为区域管理员
    public function isRegionAdmin()
    {
        if((int)$this->isSon()===1 && (int)$this->isAdmin()===1)
            return 1;
        else
            return 0;
    }

    //获取当前用户对应的学生列表
    public function getStudentsByUserIdAndKlassId($userId = null, $klassId = NULL)
    {
        if ($userId === null)
        {
            $userId = $this->user['id'];
        }
        $map = [];
        if (NULL !== $klassId) {
            $map['klass__id'] = $klassId;
        }
        $map['user_id'] = $userId;
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

    public function getAllStudentsByKlassId($klassId = NULL) {
        $map = [];
        if (NULL !== $klassId) {
            $map['klass__id'] = $klassId;
        }
        $datas = $this->UserKlassStudentViewL->where($map)->getLists();
        $this->totalCount = $this->UserKlassStudentViewL->getTotalCount();
        return $datas;
    }

    //页面输出学生列表
    public function getStudents()
    {
        // 获取班级信息
        $klassId = I('klassId');
        if (!$klassId) {
            $klassId = NULL;
        }

        if ($this->isSon() === 1) {
            // 区域管理员
            if($this->isAdmin() === 1) {
                // 系统管理员，则返回本区域的信息
                return $this->getDepartmentStudentsByKlassId($klassId);
            }
            else {
                // 返回自己的信息
                return $this->getStudentsByUserIdAndKlassId($this->user['id'], $klassId);
            }
        } else {
            // 超级管理员，返回所有的学生数据
            return $this->getAllStudentsByKlassId($klassId);
        }
    }

    public function getDepartmentStudentsByKlassId($klassId = NULL) {
        if ($klassId === NULL) {
            return $this->getDepartmentStudents();
        } else {
            $map['department__id'] = $this->user['department_id'];
            $map['klass__id'] = $klassId;
            $datas = $this->UserKlassStudentViewL->addMaps($map)->getLists();
            $this->totalCount = $this->UserKlassStudentViewL->getTotalCount();
            return $datas;
        }
    }

    //获取学生进度
    public function getProgressByStudentId($studentId)
    {
        return $this->TestStudentTestPercentCourseViewL->getProgressByStudentId($studentId);
    }


    /**
     * 获取学生所在的班级
     * @param  int $klassId 班级id
     * @return string 班级名称                        
     */
    public function getKlassByKlassId($klassId)
    {
        //dump($klassId);
        $map = array();
        $map['klass__id'] = (int)$klassId;
        $Klass = $this->UserKlassStudentViewL->where($map)->find();
        return $Klass['klass__name'];
    }

    /**
     *获取卡密有效期至
     * @param int $studenId 学生id
     * @return int 截止日期
     */
    public function getDeadlineByStudentId($studentId)
    {
        $map = array();
        $map['student__id'] = (int)$studentId;
        $deadline = $this->CardStudentCardBatchViewL->where($map)->find();
        return $deadline['deadline'];
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

    /**
     * 根据学生id获取学生的登录名
     * @param int 学生id
     * @return string
     */
    public function getStudentUserNameByStudentId($studentId)
    {
        return $this->getStudentByStudentId($studentId)['username'];
    }

    /**
     * 根据学生id获取学生的姓名
     * @param int 学生id
     * @return string 姓名
     */
    public function getStudentNameByStudentId($studentId)
    {
        return $this->getStudentByStudentId($studentId)['name'];
    }

    /**
     * 根据学生id获取学生家长电话号码
     * @param  int $studentId 学生id
     * @return string            电话号码
     */
    public function getStudentPhonenumberByStudentId($studentId)
    {
        return $this->getStudentByStudentId($studentId)['phonenumber'];
    }
    /**
     * 根据学生id获取学生的状态
     * @param int 学生id
     * @return int 状态
     */
    public function getStudentStatusByStudentId($studentId)
    {
        return $this->getStudentByStudentId($studentId)['status'];
    }

    /**
     * 根据学生id获取学生的是否卡时信息
     * @param int 学生id
     * @return int 是否卡时
     */
    public function getStudentIsStopByStudentId($studentId)
    {
        return $this->getStudentByStudentId($studentId)['is_stop'];
    }

    //根据学生id获取学生的性别
    public function getStudentSexByStudentId($studentId)
    {
        return $this->getStudentByStudentId($studentId)['sex'];
    }

    //获取当前用户的 班级列表
    public function getListsByUserId($userId = null)
    {
        if ($userId === null)
        {
            $userId = $this->user['id'];
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

    /**
     * 根据学生id获取卡密信息
     * @param int 学生id
     * @return array() 卡密信息
     * 未对find()查询失败进行判断
     * anqiang
     */
    public function getCardByStudentId($studentId)
    {
        $map['student_id'] = $studentId;
        $data = $this->CardL->where($map)->find();
        return $data;
    }

    //根据学生studentId获取其所在学校
    public function getSchoolByStudentId($studentId)
    {
        return $this->getStudentByStudentId($studentId)['school'];
    }
}