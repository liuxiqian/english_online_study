<?php
/**
 * 自我测试
 */
namespace Admin\Controller;

use SelfTest\Logic\SelfTestLogic;   //课程

class SelfTestController extends AdminController
{
    public function indexAction(){
        $this->display();
    }
}