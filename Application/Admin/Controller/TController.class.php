<?php
namespace Admin\Controller;

class TController
{
    public function indexAction()
    {
        // $T = new \Student\Model\StudentModel();
        // $T->where(array("name"=>"2"))->delete();
        // dump((int)null);
        // $T = new \WordProgressLoginWordCourseView\Logic\WordProgressLoginWordCourseViewLogic();
        // dump($T->getSurplusWordByCourseIdStudentId(1,6));
        // $T = new \Card\Logic\CardLogic();
        // dump($T->validate('2016051314631358194451001',qgptpf7lnsz3npjinrsf));
        // dump(time());
        $M = new \Admin\Model\Student\BaseModel();
        dump($M->getStudentUserNameByStudentId(1));
    }
}
