<?php
/**
 * 用户管理
 * panjie
 * 2016.4
 */
namespace User\Logic;

use User\Model\UserModel;


class UserLogic extends UserModel
{
    public function validate($user)
    {
        $map = array();
        $map['username'] = $user['username'];
        $map['password'] = $this->makePassword($user['password']);
        // dump($map);
        // exit();

        if ($this->where($map)->find() === null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }  
    
    //根据用户名取用户信息
    //$name string
    public function getListByUsername($username)
    {
        $map = array();
        $map['username'] = trim($username);
        return $this->where($map)->find();
    }

    //重置密码
    public function resetPassword($userId)
    {
        if ((int)$userId === 0)
        {
            $this->error = "系统错误!";
            return false;
        }
        else
        {
            $data['id'] = $userId;
            $data['password'] = C(DEFAULT_PASSWORD);
            // dump($data['password']);
            // exit();
            $this->saveList($data);
            return true;
        }
    }
}