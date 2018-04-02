<?php
namespace Home\Model;

use User\Logic\UserLogic;
use UserDepartmentPostView\Logic\UserDepartmentPostViewLogic;

class Teacher implements \JsonSerializable
{
    private $id             = 0;     //教师id
    private $name           = "";    //姓名
    private $email          = "";    //邮件
    private $phonenumber    = "";    //联系电话
    private $username       = '';       // 用户名 
    private $departmentPostId = 0;  // 部门岗位ID

    public function __construct($id = 0)
    {
        $id = (int)$id;
        $this->id = $id;
         if($id!==0)
        {
            $UserL = new UserLogic();
            $user = $UserL->where("id=$id")->find();
            if($user !== null)
            {
                $this->name = $user['name'];
                $this->email = $user['email'];
                $this->username = $user['username'];
                $this->phonenumber = $user['phonenumber'];
                $this->departmentPostId = (int)$user['department_post_id'];
            }
            unset($UserL);
            unset($user);
        }   
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    public function getDepartmentPostId()
    {
        return $this->departmentPostId;
    }

    /**
     * 获取部门岗位信息
     * @return DepartmentPost 
     */
    public function getDepartmentPost()
    {
        if (null === $this->departmentPost)
        {
            $this->departmentPost = new DepartmentPost($this->getDepartmentPostId());
        }
        return $this->departmentPost;
    }

    /**
     * 获取教师对应的岗位信息
     * @return Post 
     */
    public function getPost()
    {
        if (null === $this->Post)
        {
            $this->Post = $this->getDepartmentPost()->getPost();
        }
        return $this->Post;
    }

    /**
     * 获取可以查看的教师列表
     * @return array Teachers
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getAllowedTeachers()
    {
        if (null === $this->allowedTeachers)
        {
            $this->allowedTeachers = array();
            $UserDepartmentPostViewL = new UserDepartmentPostViewLogic();

            // 如果用户是系统管理员
            if ($this->getDepartmentPost()->getPost()->getIsAdmin())
            {
                $map = array();

                // 是子区域，则只查询本部门的人员
                if ($this->getDepartmentPost()->getDepartment()->getIsSon())
                {
                    $map['department_id'] = $this->getDepartmentPost()->getDepartment()->getId();
                }

                $datas = $UserDepartmentPostViewL->where($map)->field('id')->order('id desc')->select();
                foreach ($datas as $data)
                {
                    $this->allowedTeachers[] = new Teacher($data['id']);
                }
            } else 
            // 如果不是管理员，则返回当前教师
            { 
                $this->allowedTeachers[] = $this;
            } 
        }

        return $this->allowedTeachers;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'phonenumber' => $this->getPhonenumber(),
            'post'  => $this->getDepartmentPost()->getPost(),
            'department' => $this->getDepartmentPost()->getDepartment(),
        ];
    }
}
