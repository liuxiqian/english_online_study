<?php
namespace Admin\Controller;

use User\Logic\UserLogic;                                       //用户表
use Admin\Model\User\BaseModel;                                 //用户小模型
use Home\Model\Teacher;                                               // 用户，教师
use Home\Model\DepartmentPost;                                  // 岗位部门
use DepartmentPost\Model\DepartmentPostModel;                   // 部门岗位
use Home\Model\Department;                                      // 部门

class UserController extends AdminController
{
    public function indexAction()
    {
        //取当前用户信息
        $user = $this->getUser();
        $M = new BaseModel();
        $M->setCurrentUserId($user['id']);

        $this->assign("M", $M);
        $this->display();
    }

    public function editAction()
    {
        // 传入一个空的Teacher
        $Teacher = new Teacher(I('get.id'));

        // 传入当用户，以获取当前用户下的岗位列表
        $Teacher->getDepartmentPost()->getDepartment()->setTeacher($this->Teacher);
        $this->assign('Teacher', $Teacher);

        // 传入当前Teacher
        $currentTeacher = $this->Teacher;

        // 取出当前用户可以操作的部门列表
        $allowedDepartments = Department::getAllowedDepartments($currentTeacher);

        $this->assign('allowedDepartments', $allowedDepartments);
        $this->assign('currentTeacher', $currentTeacher);

        //设置当前编辑用户信息
        $M = new BaseModel();
        $M->setUserId(I('get.id'));

        //设置当前登录用户信息
        $currentUser = $this->getUser();
        $M->setCurrentUserId($currentUser['id']);
        
        //传给前台
        $this->assign('M',$M);
        $this->display('add');
    }

    public function addAction()
    {
        // 传入一个空的Teacher
        $Teacher = new Teacher();
        $this->assign('Teacher', $Teacher);

        // 传入当前Teacher
        $currentTeacher = $this->Teacher;

        // 取出当前用户可以操作的部门列表
        $allowedDepartments = Department::getAllowedDepartments($currentTeacher);

        $this->assign('allowedDepartments', $allowedDepartments);
        $this->assign('currentTeacher', $currentTeacher);

        //设置当前登录用户信息
        $M = new BaseModel();
        $currentUser = $this->getUser();
        $M->setCurrentUserId($currentUser['id']);
        //传给前台
        $this->assign('M',$M);
        $this->display('add');
    }


    public function saveAction()
    {
        $UserL = new UserLogic();
        $post = I('post.');
        if((int)$post['id'] === 0)//若是新增用户，那么赋予默认密码
        {
            $post['password'] = C('DEFAULT_PASSWORD');
        }

        // 获取要添加的部门岗位信息的对应关系
        $map = array();
        $map['department_id'] = $post['department_id'];
        $map['post_id'] = $post['post_id'];
        $DepartmentPost = DepartmentPost::get($map);
        
        // 判断是否在表中存在
        if (0 === (int)$DepartmentPost->getId())
        {
            $this->error('传入部门岗位信息有误', U("index?id=", I('get.')));
            return;
        }

        // 加入部门岗位字段 
        $post['department_post_id'] = $DepartmentPost->getId();

        // 数据更新
        if ($UserL->saveList($post) === false)
        {
            $this->error("保存错误:" . $UserL->getError(), U("index?id=",I('get.')));
            return;
        }

        $this->success("操作成功",U("index?id=",I('get.')));
        return;
    }

    public function deleteAction()
    {
        //取id
        $userId = I('get.id');

        $UserL = new UserLogic();
        if($UserL->deleteList($userId) === false)
        {
           $this->error("删除失败：" . $UserL->getError(), U('index?id=', I('get.')));
            return;
        }
        else
        {
            $this->success('操作成功', U('index?id=', I('get.')));
            return;
        }
    }

    public function resetPasswordAction()
    {
        $userId = I('get.id');
        $UserL = new UserLogic();
        $status = $UserL->resetPassword($userId);
        if($status !== false)
        {
            $this->success('您的密码已重置，新密码为:' . C(DEFAULT_PASSWORD),U('index?id=' , I('get.')));
            return;
        }
        else
        {
            $this->error("重置失败",U('index?id=' , I('get.')));
            return;
        }
    }

    /**
     * 验证用户名是否已被使用
     * @author xulinjie
     * @param  $username
     * @return true or false
     */
    public function validateAjaxAction($username = null)
    {
        $data['status'] = "ERROR";

        if ($username !== null) {
            $UserL = new UserLogic();

            $map['username'] = $username;
            $list = $UserL->where($map)->find();

            if ($list === null) {
                $data['status'] = "SUCCESS";
            }
            if ($list === false) {
                $data['data'] = "查询出错";
            }
        }
        $this->ajaxReturn($data);
    }
}

