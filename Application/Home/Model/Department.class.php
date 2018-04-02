<?php
namespace Home\Model;
use Department\Model\DepartmentModel;                // 部门
use DepartmentPost\Model\DepartmentPostModel;       // 部门岗位

class Department implements \JsonSerializable
{
    private $id = 0;
    private $title = '';
    private $isSon = 1;
    private $Teacher = null;

    public function __construct($id)
    {
        $id = (int)$id;
        $DepartmentM = new DepartmentModel;
        $data = $DepartmentM->where('id=' . $id)->find();
        if (null !== $data)
        {
            $this->id = $id;
            $this->title = $data['title'];
            $this->isSon = (int)$data['is_son'];
        }
        unset($DepartmentM);
        unset($data);
    }

    public function setTeacher($Teacher)
    {
        $this->Teacher = $Teacher;
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function getTitle()
    {
        return (string)$this->title;
    }

    public function getIsSon()
    {
        return (int)$this->isSon;
    }

    /**
     * 获取 某个 用户的可供选择的部门列表
     * @param  Teacher &$Teacher 用户
     * @return array
     */
    static public function getAllowedDepartments(&$Teacher)
    {
        if (!is_object($Teacher) || get_class($Teacher)  !== 'Home\Model\Teacher')
        {
            E('传入的参数类型非Teacher');
        }

        // 判断是否为区域管理员
        if (1 === (int)$Teacher->getDepartmentPost()->getDepartment()->getIsSon())
        {
            $Department = $Teacher->getDepartmentPost()->getDepartment();
            $Department->Teacher = $Teacher;
            $result[] = $Teacher->getDepartmentPost()->getDepartment();
        } else {
            $DepartmentM = new DepartmentModel;
            $datas = $DepartmentM->field('id')->select();
            foreach ($datas as $data)
            {
                $Department = new Department($data['id']);
                $Department->Teacher = $Teacher;
                $result[] = $Department;
            }
            unset($DepartmentM);
        }

        return $result;
    }

    /**
     * 获取本部门对应的岗位部门信息
     * @return array [description]
     */
    public function getDepartmentPosts()
    {
        if (null === $this->DepartmentPosts)
        {
            $this->DepartmentPosts = [];
            $DepartmentPostM = new DepartmentPostModel;
            $datas = $DepartmentPostM->field('id')->where('department_id=' . $this->getId())->select();
            foreach ($datas as $data)
            {
                array_push($this->DepartmentPosts, new DepartmentPost($data['id']));
            }
            unset($datas);
            unset($DepartmentPostM);
        }
        return $this->DepartmentPosts;
    }

    /**
     * 获取所有的岗位信息
     * @return array Post
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getPosts()
    {
        if (null === $this->Posts)
        {
            $this->Posts = [];
            $DepartmentPosts = $this->getDepartmentPosts();
            foreach ($DepartmentPosts as $DepartmentPost)
            {
                $this->Posts[] = $DepartmentPost->getPost();
            }
        }
        
        return $this->Posts;
    }

    /**
     * 获取可以被设置的岗位
     * @return [type] [description]
     */
    public function getAllowedPosts(&$Teacher)
    {
        if (!is_object($Teacher) || get_class($Teacher)  !== 'Home\Model\Teacher')
        {
            E('传入的参数类型非Teacher');
        }

        $Posts = $this->getPosts();
        // 如果不是管理员， 则返回空值
        if (!$Teacher->getDepartmentPost()->getPost()->getIsAdmin())
        {
            return [];
        }

        // 排除相关权限
        foreach ($Posts as $key => &$Post)
        {
            // 排除管理员
            if ($Post->getIsAdmin())
            {
                // 排除系统管理员
                if (!$Post->getIsSon())
                {
                    unset($Posts[$key]);
                }

                // 如果传入的Teacher是区域管理员，则排除区域管理员
                if ($Teacher->getDepartmentPost()->getPost()->getIsSon() && $Post->getIsAdmin())
                {
                    unset($Posts[$key]);
                }
            }
        }

        $Posts = array_values($Posts);
        return $Posts;
    }


    public function jsonSerialize()
    {
        if ($this->Teacher === null)
        {
            $allowedPosts = [];
        } else {
            $allowedPosts = $this->getAllowedPosts($this->Teacher);
        }

        return [
            'id'            => $this->getId(),
            'title'         => $this->getTitle(),
            'isSon'         => $this->getIsSon(),
            'Posts'         => $this->getPosts(),
            'allowedPosts'  => $allowedPosts,
        ];
    }


}