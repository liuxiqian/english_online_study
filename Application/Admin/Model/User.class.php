<?php
namespace Admin\Model;
/**
 * 用户
 * panjie
 */
use Think\Model;
use User\Logic\UserLogic;       // 用户

class User extends Model
{
    public $data = ['_class', __CLASS__];
    public function __construct($data)
    {
        if (is_array($data)) {
            $this->setData($data);
        } else {
            $this->id = (int)$data;
        }

    }

    public function getId()
    {
        return $this->id;
    }

    static public function getCurrentUser() {
        $user = session('user');
        return $user;
    }
}