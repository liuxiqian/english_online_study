<?php
/**
 * 学生 测试
 */
namespace Home\Model;
use StudentWordReviewNodeCourseView\Model\StudentWordReviewNodeCourseViewModel;     // 学生 复习节点 视图
use StudentWordStudyList\Model\StudentWordStudyListModel;                         //  复习列表
use StudentWordReviewNode\Model\StudentWordReviewNodeModel;                         // 复习 节点
use Think\Log;
use Word\Model\WordModel;                                                           // 单词表

class StudentTest
{
    private $Student = null;
    private $Test = null;
    private $StudentCourse = null; 

    public function __construct(Student $Student, Test $Test)
    {
        $this->Student = $Student;
        $this->Test = $Test;
        $this->StudentCourse = new StudentCourse($Student, $Course);
    }

    public function getStudent()
    {
        return $this->Student;
    }

    public function getTest()
    {
        return $this->Test;
    }

    public function getStudentCourse()
    {
        return $this->StudentCourse;
    }

    /**
     * 获取下一个需要复习的单词
     * @return   Word                   单词
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-17T09:41:31+0800
     */
    public function getNextReviewWord(Word $Word , $type = 'know', $isUpdate = true) {
        // 更新学习详情
        $this->getStudentCourse()->upDateReviewOrder($Word->getId());

        $StudentWordStudyListModel = new StudentWordStudyListModel;
        // 对传入的单词进行处理, 计算出该单词下次应该出现的时间
        if (0 !== $Word->getId()) {
            $StudentWordStudyListModel->computeAndSetNextAppearTime($Word, $this->getStudent(), $type);
        }
        
        // 复习列表中，存在需要现在学习的单词
        $NowWord = $StudentWordStudyListModel->getNowStudyWord($this->Student);

        // 复习列表中，不存在需要现在学习的单词。则取学习结点表中的数据
        if (0 === $NowWord->getId()) {
            $NowWord = $this->getFirstReviewWordOnNodeList(false);

            // 查看是否达到测试结点
            if ($NowWord->getIndex() >= $this->getTest()->getEndIndex()) {
                // 将当前测试的第一个单词送入复习节点
                $this->_updateToBeginIndexWord();
                return new Word();
            
            // 更新复习节点
            } else if ($isUpdate) {
                $StudentWordReviewNodeModel = new StudentWordReviewNodeModel;
                $StudentWordReviewNodeModel->updateNodeList($NowWord, $this->getStudent());
                unset($StudentWordReviewNodeModel);
            }
        }
        
        return $NowWord;
    }

    /**
     * 更新课程复习结点至测试的开始结点
     * 1. 取测试的开始结点值、课程号、学生号
     * 2. 查找当前课程中处理该结点值的单词
     * 3. 更新复习结点表，将复习的记录重置为本测试的开始节点 
     * @return   
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-08T12:14:11+0800
     */
    private function _updateToBeginIndexWord()
    {
        // 取首个结点的位置
        $beginIndex = $this->getTest()->getBeginIndex();
        $courseId = $this->getTest()->getCourse()->getId();
        $studentId = $this->getStudent()->getId();

        // 取当前结点的单词id
        $WordModel = new WordModel();
        $map = [];
        $map['index'] = $beginIndex ? $beginIndex : 1;
        $map['course_id'] = $courseId;
        $word = $WordModel->field('id')->where($map)->find();
        unset($WordModel);

        // 如果不存在当前节点单词，要么对课程单词进行过删除。要么未对课程进行单词整理
        if (is_null($word)) {
            Log::record('在' . $courseId . '课程中，未找到索引号为' . $beginIndex . '的记录');
            return false;

        // 更新复习节点至本阶段学习的起始位置
        } else {
            $StudentWordReviewNodeModel = new StudentWordReviewNodeModel;
            $map = array();
            $map['student_id'] = $studentId;
            $map['course_id'] = $courseId;
            $data = array();
            $data['word_id'] = $word['id'];
            $StudentWordReviewNodeModel->where($map)->save($data);
            unset($StudentWordReviewNodeModel);
        }
        
        return true;
    }

    /**
     * 获取当前需要复习的单词
     * @return   Word                   单词
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T13:30:38+0800
     */
    public function getCurrentReviewWord()
    {   
        if (null === $this->currentReviewWord) {
            // 复习列表中，存在需要现在学习的单词
            $StudentWordStudyListModel = new StudentWordStudyListModel();
            $this->currentReviewWord = $StudentWordStudyListModel->getNowStudyWord($this->getStudent());
            unset($StudentWordStudyListModel);

            // 复习列表中，不存在需要现在学习的单词。则取学习结点表中的数据
            if (0 === $this->currentReviewWord->getId()) {
                $this->currentReviewWord = $this->getFirstReviewWordOnNodeList();
            }
        }
        
        // 返回学生需要学习的单词
        return $this->currentReviewWord ;
    }


    /**
     * 获取复习节点上需要复习的第一个单词。
     * @param    boolean                  $isUpdate 是否进行进度的更新
     * @return   Word                             单词
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T13:31:08+0800
     */
    public function getFirstReviewWordOnNodeList($isUpdate = true)
    {
         // 获取用户当前正在学习的单词的下一单词做为用户需要学习的单词
        $StudentWordReviewNodeModel = new StudentWordReviewNodeModel;
        $NowWord = $StudentWordReviewNodeModel->getNextWord($this->getStudent(), $this->getTest()->getCourse());

        // 更新用户当前正在学习的单词
        if ($isUpdate) {
            $StudentWordReviewNodeModel->updateNodeList($NowWord, $this->getStudent());
        }
           
        unset($StudentWordReviewNodeModel);
        return $NowWord;
    }

}