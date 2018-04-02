<?php
namespace Home\Model;
use Post\Model\PostModel;       // 岗位

class Post implements \JsonSerializable
{
    private $id = 0;
    private $isSon = 1;     // 是否子区域岗位
    private $isAdmin = 0;   // 是否管理员
    private $name = '';
    public function __construct($id)
    {
        $id = (int)$id;
        $PostM = new PostModel;
        $data = $PostM->where('id=' . $id)->find();
        if (null !== $data)
        {
            $this->id = $id;
            $this->isSon = (int)$data['is_son'];
            $this->isAdmin = (int)$data['is_admin'];
            $this->name = (string)$data['name'];
        }
        unset($PostM);
        unset($data);
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function getIsSon()
    {
        return (int)$this->isSon;
    }

    public function getIsAdmin()    
    {
        return (int)$this->isAdmin;
    }

    public function getName()
    {
        return (string)$this->name;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'isSon' => $this->getIsSon(),
            'isAdmin' => $this->getIsAdmin(),
            'name' => $this->getName(),
        ];
    }
}