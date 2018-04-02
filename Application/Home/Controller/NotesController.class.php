<?php
namespace Home\Controller;

use Home\Controller\HomeController;
use Notes\Model\NotesModel;             // 教务笔记
use Home\Model\Notes;                   // 教务笔记
use Home\Model\NotesStudent;            // 学生笔记
/**
*
*/
class NotesController extends HomeController
{

    public function indexAction()
    {
        // 将笔记置为已读
        NotesStudent::setReaded($this->Student);

        // 获取 笔记 并传给V
        $Notes = Notes::getNotesByTeacher($this->Student->getKlass()->getTeacher());
        $this->assign('Notes', $Notes);
        $this->display();
    }
}
