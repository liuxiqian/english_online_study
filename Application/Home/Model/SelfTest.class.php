<?php
namespace Home\Model;

use  WordProgressLoginView\Logic\WordProgressLoginViewLogic;    // 单词学习进度 登陆 视图
/**
 * 自我测试
 */
class SelfTest extends Test
{
    private $type = 'default';                      // 自我测试类型 'explain' 效果检测；write 听写测试；all 自我评估
    private $allWords = null;   // 全部的单词信息 array Word

    public function __construct(Student $Student, $type = 'default')
    {
        parent::__construct(0);
        $this->Student = $Student;
        $this->type = $type;
        $this->setIsSelfTest(true);
        
        if ($type === 'explain')
        {
            $this->setExplainCount(50);
            $this->setTotalMinite(3);
        }
        else if ($type === 'write')
        {
            $this->setWriteCount(50);
            $this->setTotalMinite(15);
        }
        else
        {
            $this->setExplainCount(15);
            $this->setListeningCount(15);
            $this->setWriteCount(20);
            $this->setTotalMinite(10);
        }
    }

    public function getStudent()
    {
        return $this->Student;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * 获取全部的测试单词
     * @return [type] [description]
     */
    public function getAllWords()
    {
        if ($this->allWords === null)
        {
            // 查找该学生当天学习的所有 新单词
            $WordProgressLoginViewL = new WordProgressLoginViewLogic;
            $map['student_id'] = $this->getStudent()->getId();
            $time = strtotime(date('Y-m-d', time()));
            $map['time'] = array('gt', $time);
            $map['is_new'] = '1';
            $words = $WordProgressLoginViewL->field('word_id')->where($map)->select();

            // 取出一共需要取出多少个单词
            // 如果所有新学单词，小于需要取出的个数，则直接报错
            $totalCount = $this->getTotalCount();
            if (count($words) < $totalCount)
            {
                E('当前学习的单词数未达到预定值');
            }

            // 当所有单词进行随机排列
            shuffle($words);

            // 取出前面N个单词
            $this->allWords = array();
            for ($i = 0; $i < $totalCount; $i++)
            {
                $this->allWords[] = new Word($words[$i]['word_id']);
            }
        }
        return $this->allWords;
    }

    /**
     * 是否允许进行自我测试
     * @return bool
     */
    public function getIsAllow()
    {
        // 比较今日新学 与 需要学的总数
        if ($this->getTodayNewStudyCount() < $this->getTotalCount())
        {
            return 0;
        }

        return 1;
    }

    /**
     * 今日新学单词的数量
     * @return int 
     */
    public function getTodayNewStudyCount()
    {
        if (null === $this->todayNewStudyCount)
        {
            $WordProgressLoginViewL = new WordProgressLoginViewLogic;
            $map['student_id'] = $this->getStudent()->getId();
            $time = strtotime(date('Y-m-d', time()));
            $map['time'] = array('gt', $time);
            $map['is_new'] = '1';
            $this->todayNewStudyCount = $WordProgressLoginViewL->where($map)->count();
            unset($WordProgressLoginViewL);
        }

        return $this->todayNewStudyCount;
    }
}