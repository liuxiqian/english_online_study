<?php
/**
 * 前台indexcontroller
 * xulinjie
 * 2106.04.25
 */
namespace Home\Controller;

use Yunzhi\Logic\HttpLogic;
use Home\Model\Student;     //学生类
use Home\Model\Word;  //单词类
// use Home\Model\studyModel;     //

class IndexController extends HomeController
{

    public function indexAction()
    {
        $this->display();
    }

    public function studyAction()
    {
        $this->display();
    }

     /**
     * 项目JS文件
     * @return [type] [description]
     */
    public function studyAppJsAction()
    {
        // $M = new studyModel();
        // $this->assign("M", $M);

        $this->display("studyApp.js");
    }

    public function reviewAction()
    {
        $this->display();
    }

    public function templatesAction()
    {
        # code...
    }

    public function wordDetialAction()
    {
    	$this->display();
    }

    public function wordTestAction()
    {
    	$this->display();
    }
    
    public function listeningTestAction()
    {
        $this->display();
    }

    public function studyWordDetailAction()
    {

        $id = I('get.wordid');
        $word = new Word((int)$id);
        $this->assign('word',$word);
        $this->display();
    }
}