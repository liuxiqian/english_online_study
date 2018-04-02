<?php
namespace Home\Model;
use Notes\Model\NotesModel;         // 教务员笔记

/**
 * notes 教务员笔记
 */
class Notes
{
    private $id = 0;
    private $userId = 0;
    private $text = '';
    private $time = '';

    public function __construct($id)
    {
        $id = (int)$id;
        $NotesM = new NotesModel();
        $notes = $NotesM->where('id=' . $id)->find();
        if ($notes !== null)
        {
            $this->id = (int)$notes['id'];
            $this->userId = (int)$notes['user_id'];
            $this->text = (string)$notes['text'];
            $this->time = (int)$notes['time'];
        }
        unset($NotesM);
    }   

    public function getId()
    {
        return (int)$this->id;
    }

    public function getUserId()
    {
        return (int)$this->userId;
    }

    public function getText()
    {
        return (string)$this->text;
    }

    public function getTime()
    {
        return (string)$this->time;
    }

    /**
     * 通过用户 获取 用户对应的教务笔记
     * @param  Teacher &$Teacher 教师
     * @return Notes         笔记
     * @author panjie <panjie@yunzhiclub.com>
     */
    static public function getNotesByTeacher(&$Teacher)
    {
        if (!is_object($Teacher) || (get_class($Teacher) !== 'Home\Model\Teacher'))
        {
            E('传入的变量类型非Teacher类型');
        }

        // 查询对应的教务笔记 
        $NotesM = new NotesModel();
        $map = array('user_id'=>$Teacher->getId());
        $notes = $NotesM->field('id')->where($map)->find();
        unset($NotesM);
        return new Notes((int)$notes['id']);
    }
}