<?php
namespace StudentWordStudyNode\Model;
use Think\Model;
use Home\Model\Word;
use Home\Model\Student;
use Home\Model\Course;

/**
 * 学生单词学习记录.记录学生在学习过程中需要重复学习的单词及时点
 */
class StudentWordStudyNodeModel extends Model
{
    public function updateNodeList(Word &$Word, Student &$Student)
    {
        // 删除原有记录
        $map = [];
        $map['course_id'] = $Word->getCourseId();
        $map['student_id'] = $Student->getId();
        $data = $this->field('max_index')->where($map)->find();

        if (is_null($data)) {
            $data = $map;
            $data['word_id'] = $Word->getId();
            $data['max_index'] = $Word->getIndex();
            $this->data($data)->add();
        } else {
            if ((int)$data['max_index'] < $Word->getIndex()) {
                $data['max_index'] = $Word->getIndex();
            }
            $data['word_id'] = $Word->getId();
            $this->where($map)->save($data);
        }

        return;
    }

    /**
     * 获取学习过程中，学生所学的最大索引号, 即复习的总单词数
     * @param    Student                  $Student 学生
     * @param    Course                   $Course  课程
     * @return   int
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-20T15:04:25+0800
     */
    public function getMaxIndex(Student &$Student, Course &$Course)
    {
        $map = [];
        $map['student_id'] = $Student->getId();
        $map['course_id'] = $Course->getId();
        $data = $this->where($map)->find();
        if (is_null($data)) {
            return 0;
        } else {
            return (int)$data['max_index'];
        }
    }
    /**
     * 获取学生某门课程下一个需要学习的单词
     * @param    Student                  &$Student 学生
     * @param    Course                   &$Course  课程
     * @return   Word                             单词
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-11T10:04:55+0800
     */
    public function getNextWord(Student &$Student, Course &$Course)
    {
        $studingWord = $this->_getStudingWordData($Student, $Course);
        // 不存在，则取该课程的第一个单词
        if (null === $studingWord) {
            $Word = $Course->getFirstWord();

        // 存在历史学习单词，则取该单词的下一单词
        } else {
            $NowWord = new Word($studingWord['word_id']);
            $Word = $NowWord->getNextWord();
        }

        return $Word;
    }

    /**
     * 获取正在学习的单词
     * @param    Student                  &$Student 学生
     * @param    Course                   &$Course  课程
     * @return   Word                             单词
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-17T09:32:24+0800
     */
    public function getStudingWord(Student &$Student, Course &$Course)
    {
        $data = $this->_getStudingWordData($Student, $Course);
        if ($data !== null) {
            return new Word($data['word_id']);
        } else {
            return new Word(0);
        }
    }

    /**
     * 获取正在学习的单词数据list
     * @param    Student                  &$Student 学生
     * @param    Course                   &$Course  课程
     * @return   array                             
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-17T09:32:40+0800
     */
    private function _getStudingWordData(Student &$Student, Course &$Course)
    {
        $map = [];
        $map['student_id'] = $Student->getId();
        $map['course_id'] = $Course->getId();
        $data = $this->where($map)->find();
        return $data;
    }
}