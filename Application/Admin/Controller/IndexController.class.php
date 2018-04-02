<?php
/**
 * 后台管理系统着陆页
 * panjie
 * 2016.04
 */
namespace Admin\Controller;

use Think\Controller;
use User\Logic\UserLogic;
use Admin\Model\User\BaseModel;

class IndexController extends AdminController {

    //首页
    public function indexAction(){

        //取当前用户信息
        $user = $this->getUser();
        $M = new BaseModel();
        $M->setCurrentUserId($user['id']);

        $this->assign("M", $M);
        $this->display();
    }
}
