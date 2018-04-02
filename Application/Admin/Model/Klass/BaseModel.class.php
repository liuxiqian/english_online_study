<?php
namespace Admin\Model\Klass;

use KlassUserView\Logic\KlassUserViewLogic;
use UserDepartmentPostView\Logic\UserDepartmentPostViewLogic;
use Student\Logic\StudentLogic;
/*
基类
 */
class BaseModel
{
    protected $user;                                //当前登录用户信息
    protected $teachers;                            //当前登录用户的可查教师信息
    protected $UserDepartmentPostViewL = null;
    protected $KlassUserViewL = null;

    public function __construct()
    {
        $this->UserDepartmentPostViewL = new UserDepartmentPostViewLogic();
        $this->KlassUserViewL = new KlassUserViewLogic();
        $teacher_id = (int)I("get.teacher_id");

        if ($teacher_id)
        {
            $map['user_id'] = $teacher_id;
            $this->KlassUserViewL->addMaps($map);
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
        if((int)$this->user['department__is_son'] === 1)
            return 1;
        else
            return 0;
    }

    //判断当前用户是否为管理员 
    public function isAdmin()
    {
        if((int)$this->user['post__is_admin'] === 1)
            return 1;
        else
            return 0;
    }

    //获取当前用户的 当前页数据
    public function getListsByUserId($userId = null)
    {
        if ($userId === null)
        {
            $userId = $this->user['id'];
        }
        $map['user_id'] = $userId;
        return $this->KlassUserViewL->addMaps($map)->getLists();
    }

    //获取当前用户所在部门下的 当前页数据
    public function getDepartmentLists()
    {
        $map['department_id'] = $this->user['department_id'];
        return $this->KlassUserViewL->addMaps($map)->getLists();
        
    }

    //获取班级视图下的 当前页数据。
    public function getLists()
    {
        return $this->KlassUserViewL->getLists();
    }

    //获取所有教师
    public function getAllTeachers()
    {
        $map['post__is_son'] = 1;
        $map['post__is_admin'] = 0;
        return $this->UserDepartmentPostViewL->setMaps($map)->getAllLists();
    }

    //获取当前区域的所有教师
    public function getCurrentDepartmentTeachers()
    {
        $map['department_id'] = $this->user['department_id'];
        $map['post__is_admin'] = 0;
        return $this->UserDepartmentPostViewL->setMaps($map)->getAllLists();
    }

    public function getTeachers()
    {
        return $this->teachers;
    }

    public function setTeachers($teachers)
    {
        $this->teachers = $teachers;
    }

    public function getKlassNameByKlassId($klassId)
    {
        $map['id'] = (int)$klassId;
        $data = $this->KlassUserViewL->where($map)->find();
        return $data['name'];
    }

    //通过班级Id获取学生信息列表
    public function getStudentListsByKlassId($klassId)
    {
        $map = array();
        $map['klass_id'] = (int)$klassId;
        dump($klassId);
        $StudentL = new StudentLogic();
        $datas = $StudentL->where($map)->select();
        return $datas;
    }
}

// $Test = new BaseModel();
// $Test->setUserId(3);
// dump($Test->getCurrentTeachers());
