<?php
namespace StudentWordReviewNodeAll\Model;
use think\Model;
use Home\Model\Word;

/**
 * 学生学习所有单词时的学习节点，每个学生只记录一条信息。
 */
class StudentWordReviewNodeAllModel extends Model
{
    /**
     * 设置正在学习的单词
     * @param    int                   $wordId    单词id
     * @param    int                   $studentId 学生id
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-27T08:57:00+0800
     */
    public function setNowStudyWord($wordId, $studentId)
    {
        // 删除原有记录
        $map = [];
        $map['student_id'] = (int)$studentId;
        $this->where($map)->delete();

        // 添加新记录
        $data = [];
        $data['word_id'] = (int)$wordId;
        $data['student_id'] = (int)$studentId;
        $this->add($data);

        return ;
    }

    /**
     * 获取下一个要学习的单词
     * @param    int                   $studentId 学生id
     * @return   Word                              单词
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-27T10:13:43+0800
     */
    public function getNextStudyWord($studentId)
    {
        $nowStudyWord = $this->getNowStudentWord($studentId);
        return $nowStudyWord->getNextWord();
    }

    /**
     * 获取正在学习的单词
     * @param    int                   $studentId 学生id
     * @return   Word                              单词
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-27T10:13:58+0800
     */
    public function getNowStudentWord($studentId)
    {
        $map = array();
        $map['student_id'] = (int)$studentId;
        $data = $this->where($map)->find();
        if (!is_null($data)) {
            return new Word($data['word_id']);
        } else {
            return new Word(0);
        }
    }
}