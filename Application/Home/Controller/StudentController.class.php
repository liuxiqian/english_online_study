<?php
namespace Home\Controller;

use Home\Model\Word;            // 单词

class StudentController extends HomeController
{
    public function indexAction()
    {
        $this->assign("Word", new Word(1));
        $this->display();
    }
    public function identifyAction()
    {
        $this->display();
    }
    public function reviewAction()
    {
        $this->display();
    }
}
