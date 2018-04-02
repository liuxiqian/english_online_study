<?php
namespace Home\Model;
use DepartmentPost\Model\DepartmentPostModel;       // 部门岗位

class DepartmentPost implements \JsonSerializable
{
    private $id = 0;
    private $departmentId = 0;  // 部门id
    private $postId = 0;        // 岗位ID

    public function __construct($id)
    {
        $id = (int)$id;
        $DepartmentPostM = new DepartmentPostModel;
        $data = $DepartmentPostM->where('id=' . $id)->find();
        if (null !== $data)
        {
            $this->id = (int)$data['id'];
            $this->departmentId = (int)$data['department_id'];
            $this->postId = (int)$data['post_id'];
        }
        unset($DepartmentPostM);
        unset($data);
    }
    public function getId()
    {
        return (int)$this->id;
    }
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function getDepartment()
    {
        if (null === $this->Department)
        {
            $this->Department = new Department($this->getDepartmentId());
        }
        return $this->Department;
    }

    public function getPost()
    {
        if (null === $this->Post)
        {
            $this->Post = new Post($this->getPostId());
        }
        return $this->Post;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'post' => $this->getPost(),
            // 'department' => $this->getDepartment()
        ];
    }

    /**
     * 通过条件获取当前对象
     * @param  array|string $map 条件
     * @return DepartmentPost      
     * @author panjie <panjie@yunzhiclub.com>
     */
    static public function get($map)
    {
        $DepartmentPostM = new DepartmentPostModel;
        $data = $DepartmentPostM->field('id')->where($map)->find();
        return new DepartmentPost((int)$data['id']);
    }
}