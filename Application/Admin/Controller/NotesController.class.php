<?php
namespace Admin\Controller;
use Home\Model\Notes;           // 笔记
use Notes\Model\NotesModel;     // 笔记
use Home\Model\Teacher; 
use Home\Model\NotesStudent;    // 学生查阅教程笔记记录

class NotesController extends AdminController
{
    /**
     * 获取当前教师的笔记
     * @return  
     * 
     */
    private function _getNotes()
    {
        // 获取当前教师的笔记
        $Teacher = new Teacher($this->User->getId());
        $this->Notes = Notes::getNotesByTeacher($Teacher);
    }

    public function indexAction()
    {
        // 获取笔记
        $this->_getNotes();

        $this->assign('Notes', $this->Notes);
        $this->display();
    }

    public function saveAction()
    {   
        // 获取笔记
        $this->_getNotes();

        // 更新记录
        $NotesM = new NotesModel;
        $data = array();
        if (0 !== (int)$this->Notes->getId()) {
            $data['id'] = (int)$this->Notes->getId();
        }

        $data['text'] = I('post.text');
        $data['user_id'] = (int)$this->User->getId();
        $data['time'] = time();


        // 保存
        if (false === $NotesM->saveList($data))
        {
            $this->error('保存错误：' . $NotesM->getError());
            return;
        }

        // 将本记录设置为未读
        NotesStudent::setUnReaded($this->Notes);
        return $this->success('操作成功', U('index'));
    }
}