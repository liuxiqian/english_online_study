<?php
/**
*zhangjiahao
*/
namespace Admin\Model\User;

use UserDepartmentPostView\Logic\UserDepartmentPostViewLogic;           //用户区域岗位视图
use DepartmentPostView\Logic\DepartmentPostViewLogic;                   //区域岗位视图
use Department\Logic\DepartmentLogic;                                   //区域表
use Home\Model\Teacher;                                                 // 教师
use Home\Model\Department;                                              // 部门
use Post\Logic\PostLogic;

class BaseModel
{
    public $user = array();                         //当前用户信息
    public $currentUser = array();                   //当前登陆用户
    protected $UserDepartmentPostViewL = null;      //用户区域岗位视图对象
    protected $DepartmentPostViewL = null;           //区域岗位视图对象
    protected $DepartmentL = null;                   //区域对象
    public $totalCount                              = 0;        //数据总数
    private $CurrentTeacher;

    public function __construct()
    {
        // $this->user = new \stdClass();
        $this->UserDepartmentPostViewL = new UserDepartmentPostViewLogic();
        $this->DepartmentPostViewL = new DepartmentPostViewLogic();
        $this->DepartmentL = new DepartmentLogic();

        $this->PostL = new PostLogic();

        $department_id = (int)I("get.department_id");
        $post_id = (int)I("get.post_id");

        if ($department_id)
        {
            $map['department_id'] = $department_id;
            $this->UserDepartmentPostViewL->addMaps($map);
        }
        if ($post_id)
        {
            $map['post_id'] = $post_id;
            $this->UserDepartmentPostViewL->addMaps($map);
        }

    }

    //判断当前ACTION是edit还是add
    public function checkIsEdit()
    {
        if(ACTION_NAME === 'edit')
            return 1;
        else
            return 0;
    }

    /**
     * 判断是否教务员
     * @author xulinjie
     * @return 是返回1；否返回0
     */
    public function isTeacher()
    {
        //只有子岗位，且不是管理员的才是教务员
        if ((int)$this->currentUser['post__is_son'] !== 1) {
            return 0;
        }
        if ((int)$this->currentUser['post__is_admin'] !== 0) {
            return 0;
        }
        return 1;
    }

    //根据userId设置当前登录用户
    public function setCurrentUserId($userId)
    {
        $map['id'] = (int)$userId;
        $this->currentUser = $this->UserDepartmentPostViewL->where($map)->find();
        $this->Teacher = new Teacher($userId);
        return;
    }

    //通过userId设置当前编辑用户信息
    public function setUserId($userId)
    {
        $map['id'] = (int)$userId;
        $this->user = $this->UserDepartmentPostViewL->where($map)->find();
        return;
    }

    /**
     * 在C层中setUserId($userId)
     * 然后直接获取当前用户信息即可。
     * @return list
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getTeacher()
    {
        return $this->Teacher;
    }

    //获取当前登录用户所能看见的用户列表
    public function getCurrentUserLists()
    {
        if (null === $this->currentUserLists)
        {
            $this->currentUserLists = array();
            $map = array();

            // 判断当前用户是否为根区域用户
            if((int)$this->currentUser['department__is_son'] === 0)
            {
                // 去除根用户自己
                $map['_string'] = 'post__is_admin <> 1 OR post__is_son <> 0';
                $this->currentUserLists = $this->UserDepartmentPostViewL->addMaps($map)->getLists();
                $this->totalCount = $this->UserDepartmentPostViewL->getTotalCount();
            }
            else
            {
                // 排除管理员
                $map = array();
                $map['post__is_admin'] = '0';
                $map['department_id'] = $this->currentUser['department_id'];
                $this->currentUserLists = $this->UserDepartmentPostViewL->addMaps($map)->getLists();
                $this->totalCount = $this->UserDepartmentPostViewL->getTotalCount();
            }
        }

        return $this->currentUserLists;
    }

    // 获取当前登陆用户所允许添加的区域
    public function getCurrentUserAllowedDepartment()
    {
        //不是子区域，则获取所有的区域信息
        if((int)$this->currentUser['department__is_son'] === 0)
        {
            return $this->DepartmentL->select();
        }
        // 是子区域的话，将用户当前子区域信息返回
        else
        {
            $map['id'] = $this->currentUser['department_id'];
            return $this->DepartmentL->where($map)->select();
        }
    }

    /**获取全部的 部门岗位信息
     * @return lists
     */
    public function getCurrentUserDeparmentPosts()
    {
        $map = array();
        $map['post__is_admin'] = 0;

        // 是子区域，则获取子区域岗位信息
        if((int)$this->currentUser['department__is_son'] === 1)
        {
            $map['department__is_son'] = 1;
            $map['department_id'] = $this->currentUser['department_id'];
        }

        $deparmentPosts = $this->DepartmentPostViewL->where($map)->select();
        $deparmentPosts = group_by_key($deparmentPosts, "department_id");
        return $deparmentPosts;
    }

    /**
     * 获取当前岗位
     * @author xulinjie
     * @return $lists
     */
    public function getCurrentUserPosts()
    {
        if (null === $this->currentUserPosts)
        {
            // 是子区域，则获取子区域岗位信息
            if ((int)$this->currentUser['department__is_son'] === 1){
                $map['is_son'] = 1;
            }

            $this->currentUserPosts = $this->PostL->where($map)->select();

            // 去除系统管理员
            foreach ($this->currentUserPosts as $key => &$value)
            {
                if (($value['is_admin'] == '1') && ($value['is_son'] == '0'))
                {
                    unset($this->currentUserPosts[$key]);
                }
            }
        }

        return $this->currentUserPosts;
    }
}
