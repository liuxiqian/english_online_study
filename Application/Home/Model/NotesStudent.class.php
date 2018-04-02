<?php
namespace Home\Model;
use NotesStudent\Model\NotesStudentModel;

class NotesStudent
{
    private $id = 0;
    private $notesId = 0;
    private $studentId = 0;

    public function __construct($id = 0)
    {
        $this->id = (int)$id;
        if ($this->id)
        {
            $NotesStudentM = new NotesStudentModel;
            $list = $NotesStudentM->where('id=' . $this->id)->find();
            if (null !== $list)
            {
                $this->notesId      = (int)$list['notes_id'];
                $this->studentId    = (int)$list['student_id'];
            }
            unset($NotesStudentM);
        }
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function getNotesId()
    {
        return (int)$this->notesId;
    }

    public function getStudentId()
    {
        return (int)$this->studentId;
    }

    public function getNotes()
    {
        if (null === $this->Notes)
        {
            $this->Notes = new Notes($this->getNotesId());
        }

        return $this->Notes;
    }

    public function getStudent()
    {
        if (null === $this->Student)
        {
            $this->Student = new Student($this->getStudentId());
        }

        return $this->Student;
    }

    /**
     * 获取未读的通知列表
     * @param  Student &$Student 学生
     * @return array            
     */
    static public function getReadedNotes(Student &$Student)
    {
        $map = array();
        // 先找出对应老师的NOTES
        
        // 再查找是否已读
        $Notes = Notes::getNotesByTeacher($Student->getKlass()->getTeacher());

        $map = array();
        $map['notes_id'] = $Notes->getId();
        $map['student_id'] = $Student->getId();

        $NotesStudentM = new NotesStudentModel;
        $list = $NotesStudentM->where($map)->find();
        if (null === $list)
        {
            return new NotesStudent;
        }

        return new NotesStudent($list['id']);
    }

    /**
     * 获取未读的通知列表个数
     * @param  Student &$Student 学生
     * @return int            
     */
    static public function getReadedNotesCount(Student &$Student)
    {
        $NotesStudent = self::getReadedNotes($Student);
        if (0 === $NotesStudent->getId())
        {
            return 1;
        } 
         
        return 0;
    }

    /**
     * 设置 已读
     * @param Student &$Student 学生
     */
    static public function setReaded(Student &$Student)
    {
        // 找到教务笔记ID
        $Notes = Notes::getNotesByTeacher($Student->getKlass()->getTeacher());

        // 找记录
        $data = array();
        $data['student_id'] = $Student->getId();
        $data['notes_id'] = $Notes->getId();
        $NotesStudentM = new NotesStudentModel;
        $list = $NotesStudentM->where($data)->find();

        // 无记录则添加记录
        if (null === $list)
        {
            $NotesStudentM->saveList($data);
        }

        unset($NotesStudentM);
        return true;
    }

    /**
     * 设置为未读
     * @param Notes &$Notes 笔记
     */
    static public function setUnReaded(Notes &$Notes)
    {
        $map = array();
        $map['notes_id'] = $Notes->getId();
        $NotesStudentM = new NotesStudentModel;
        $NotesStudentM->where($map)->delete();
        unset($NotesStudentM);
        return true;
    }
}