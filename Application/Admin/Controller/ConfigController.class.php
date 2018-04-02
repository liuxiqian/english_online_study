<?php
/**
    *系统设置
    *litian
    *litian0815@126.com
**/
namespace Admin\Controller;

class ConfigController extends AdminController
{
    public function indexAction(){
        $this->display();
    }
    public function customeAction(){
        $this->display();
    }
    public function dataAction(){
        $this->display();
    }
    public function blogAction(){
        $this->display();
    }
    public function personnalAction(){
        $this->display();
    }
    public function saveAction(){
        $this->success("操作成功",U('custome'));
    }
}
