<?php
namespace Home\Model;

use TestPercent\Model\TestPercentModel;                         // 测试百分比表（这名字起的！！）
use Word\Model\WordModel;                                       // 单词
use WordProgressLoginView\Logic\WordProgressLoginViewLogic;     // 单词学习进度
use WordProgressLoginWordCourseView\Logic\WordProgressLoginWordCourseViewLogic;     // 单词进度登陆 单词 课程
use StudentWordView\Model\StudentWordViewModel;     // 学生单词节点

/**
 * 测试
 */
class Test
{
    private $id                 = 0;
    private $minTaskCount       = 50;       // 最小触发自我测试所学单词数
    private $limitTime          = 0;        // 限时
    private $explainCount       = 0;        // 释义题数量
    private $listeningCount     = 0;        // 听辨题数量
    private $writeCount         = 0;        // 听写题数量
    private $totalCount         = null;     // 单词总数
    private $explainWords       = null;     // 释义题 array (Word)
    private $listeningWords     = null;     // 听辨题 array (Word)
    private $writeWords         = null;     // 听写题 array (Word)
    private $allWords           = null;     // 所有测试单词
    private $preGroupTest       = null;     // 上一个组测试
    private $totalMinite        = 0;        // 做答时间分钟
    private $type               = 0;        // 类型
    private $title              = "学前测试";// 类型名称
    private $titleList          = array(0 => "学前测试", 1 => "组测试", 2 => "阶段测试");
    private $percent            = 0;        // 百分比
    private $Course             = null;     // 学生
    private $courseId           = 0;        // 课程ID
    private $isSelfTest         = 0;       // 是否为 自我测试

    public function __construct($id = 0)
    {
        $id = (int)$id;
        $this->id       = $id;
        if (0 !== $this->id) {
            $TestPercentM           = new TestPercentModel;
            $testPercent            = $TestPercentM->where("id=$id")->find();
            if (null !== $testPercent) {
                $this->type             = (int)$testPercent['type'];
                $this->courseId         = (int)$testPercent['course_id'];
                $this->percent          = (int)$testPercent['percent'];
                $this->explainCount     = (int)$testPercent['explain_count'];
                $this->listeningCount   = (int)$testPercent['listening_count'];
                $this->writeCount       = (int)$testPercent['write_count'];
                $this->totalMinite      = (int)$testPercent['total_minite'];
            }
        }
        
        unset($TestPercentM);
    }

    /**
     * 获取某学生在某课程中 未通过测试的首个测试
     * @param    Student                  &$Student 学生
     * @param    Course                   &$Course  课程
     * @return   Test                             测试
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-11T16:21:07+0800
     */
    static public function getFirstUnpassedTestByStudentCourse(Student &$Student, Course &$Course)
    {
        // 找到全部的测试结点
        $TestPercentM = new TestPercentModel;
        $map = [];
        $map['course_id'] = $Course->getId();
        // 按百分比及type的升序取出测试列表
        $order = array('percent' => 'asc', 'type' => 'asc');
        $lists = $TestPercentM->field(['id', 'type'])->where($map)->order($order)->select();
        unset($TestPercentM);

        // 当前课程存在测试结点
        if (!empty($lists)) {
            // 依次排查测试结点，如果未通过，则返回该测试
            foreach ($lists as $list) {
                if (!TestRecord::isPassed($list['id'], (int)$list['type'], $Student)) {
                    return new self($list['id']);
                }
            }
        } 

        // 当前课程不存在测试结点 或 当前课程已学习完毕
        return new self(0);
    }

    /**
     * 获取是否自我测试
     * @return bool 
     * panjie
     */
    public function getIsSelfTest()
    {
        return $this->isSelfTest;
    }

    /**
     * 获取 JS中使用的真假值
     * @return string 'true',真;'false',假.
     * @author  panjie 
     */
    public function getJsIsSelfTest()
    {
        if ($this->isSelfTest == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }
    
    /**
     * 设置是否自我测试
     * @param bool $isSelfTest 
     * @author panjie
     */
    public function setIsSelfTest($isSelfTest)
    {
        $this->isSelfTest = (bool)$isSelfTest;
    }

    public function getTitle()
    {
        return $this->titleList[$this->getType()];
    }

    /**
     * 课程ID
     * @return int
     */
    public function getCourseId()
    {
        return $this->courseId;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getLimitTime()
    {
        return $this->limitTime;
    }

    public function getTotalCount()
    {
        if ($this->totalCount === null)
        {
            $this->totalCount = $this->getExplainCount() + $this->getListeningCount() + $this->getWriteCount();
        }
        return $this->totalCount;
    }

    public function getGrade()
    {
        return $this->grade;
    }

    public function getTime()
    {
        return $this->time;
    }

    /**
     * 释义题个数
     * @return int
     * panjie
     */
    public function getExplainCount()
    {
        return $this->explainCount;
    }

    /**
     * 设置释义题数量
     * @param int $explainCount 
     * panjie
     */
    public function setExplainCount($explainCount)
    {
        $this->explainCount = $explainCount;
    }

    /**
     * 听辨题个数
     * @return int
     * panjie
     */
    public function getListeningCount()
    {
        return $this->listeningCount;
    }

    /**
     * 设置听辨题数量
     * @param int $listeningCount 
     * panjie
     */
    public function setListeningCount($listeningCount)
    {
        $this->listeningCount = $listeningCount;
    }

    /**
     * 听写题个数
     * @return int
     * panjie
     */
    public function getWriteCount()
    {
        return $this->writeCount;
    }

    /**
     * 设置听写题数量
     * @param int $writeCount 
     * panjie
     */
    public function setWriteCount($writeCount)
    {
        $this->writeCount = $writeCount;
    }

    /**
     * 是否允许进行自我测试
     * @return bool
     */
    public function getIsAllow(Student $Student)
    {
        if ($Student->getTodayStudyCount() >= $this->minTaskCount)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * 判断学生是否拥有测试的权限
     * 直接取学生 当前进行到的测试 的百分比 与本测试进行比较
     * 如果当前进行到的测试百分比小于本测试百分比
     * 就返回false
     * @param  Student $Student [description]
     * @return boolean
     * @author  panjie
     */
    public function isAccess(Student $Student)
    {
        $currentPercent = $this->getCourse()->getCurrentTest($Student)->getPercent();
        if ($currentPercent < $this->getPercent())
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 获取本测试的所有单词 主要为了便于其它子模块的调用。
     * 1.判断考试类型
     * 2. 堕机进行抽取
     * @return array   Word
     * @author  panjie <3792535@qq.com>
     */
    public function getAllWords()
    {
        if ($this->allWords === null)
        {
            $storeKey = __CLASS__ . '_' . __METHOD__ . '_' . $this->getId();
            $this->allWords = S($storeKey);

            if (false === $this->allWords)
            {
                $this->allWords = array();

                // 取出所有的单词（正常的学习顺序）
                $Words = $this->getStudyOrderAllWords();

                // 随机取出各个题型
                $count = ($this->getTotalCount() > count($Words) ? count($Words) : $this->getTotalCount());

                $randsKeys = array_rand($Words, $count);
                foreach ($randsKeys as $key)
                {
                    $this->allWords[] = $Words[$key];
                }
                unset($WordM);
            }

        }
        return $this->allWords;
    }

    /**
     * 获取按学习顺序进行排序的所有单词
     * @return array Words
     * @author panjie
     */
    public function getStudyOrderAllWords()
    {
        if ($this->_allWords === null)
        {
            // 取缓存信息
            //$storeKey = __CLASS__ . '_' . __METHOD__ . '_' . $this->getId();
            $storeKey = $this->getId();
            $this->_allWords = Cache::get(__CLASS__, __METHOD__, $storeKey);
            
            // 缓存不存在，则取信息后送入缓存
            if (false === $this->_allWords)
            {
                $this->_allWords = array();
                $WordM = new WordModel();
                $order = array("index"=>"asc");

                // 判断当前测试的类型
                // 为学前测，则以全部的单词为范本
                if ($this->getType() === 0 )
                {
                    $beginPercent   = 0;
                    $endPercent     = 100;
                }

                // 为组测试，则以上一组结束至本组开始单词为范本
                else if($this->getType() === 1)
                {
                    $beginPercent = $this->getPreGroupTest()->getPercent();
                    $endPercent = $this->getPercent();
                }

                // 为阶段测，则以课程开始至本阶段测为东西
                else if ($this->getType() === 2)
                {
                    $beginPercent = 0;
                    $endPercent = $this->getPercent();
                }

                // 取一定阶段内的数据
                $beginCount = floor($this->getCourse()->getWordCount() * $beginPercent / 100);
                $endCount = floor($this->getCourse()->getWordCount() * $endPercent / 100);
                $offset = $endCount - $beginCount;
                $map = array();
                $map['course_id'] = $this->getCourse()->getId();
                $words = $WordM->where($map)->order($order)->limit("$beginCount , $offset")->select();
                shuffle($words);
                foreach ($words as $word)
                {
                    $this->_allWords[] = new Word($word);
                }

                // 将信息送入缓存
                Cache::set(__CLASS__, __METHOD__, $storeKey, $this->_allWords);
                unset($WordM);
            }
        }
        return $this->_allWords;
    }

    /**
     * 获取上一个组测试信息
     * @return Test
     * @author  panjie <3792535@qq.com>
     */
    public function getPreGroupTest()
    {
        if ($this->preGroupTest === null)
        {
            $TestPercentM = new TestPercentModel;
            $map = array();
            $map['course_id'] = $this->getCourseId();
            $map['type'] = '1';
            $lists = $TestPercentM->where($map)->order('percent asc')->select();
            $id = 0;
            foreach ($lists as $list)
            {
                if ((int)$list['id'] === $this->getId())
                {
                    break;
                }
                else
                {
                    $id = $list['id'];
                }
            }
            $this->preGroupTest = new Test($id);
            unset($TestPercentM);
        }
        return $this->preGroupTest;
    }

    /**
     * 获取释义题列表
     * @param object Course 课程类
     * @return array(Word)
     * @author panjie
     */
    public function getExplainWords()
    {
        if ($this->explainWords === null)
        {
            // 从头开始截取
            $offset = 0;
            $length = $this->getExplainCount();
            $this->explainWords = $this->_sliceWords($offset, $length);
        }
        return $this->explainWords;
    }

    /**
     * 获取听辨题列表
     * @param
     * @return array(Word)
     * @author panjie
     */
    public function getListeningWords()
    {
        // 从释义题后面，开始截取
        if ($this->listeningWords === null)
        {
            $offset = $this->getExplainCount();
            $length = $this->getListeningCount();
            $this->listeningWords = $this->_sliceWords($offset, $length);
        }
        return $this->listeningWords;
    }

    /**
     * 获取听写题列表
     * @return array Word
     * @author panjie
     */
    public function getWriteWords()
    {
        // 从听辨题后面，开始截取
        if ($this->writeWords === null)
        {
            $offset = $this->getListeningCount() + $this->getExplainCount();
            $length = $this->getWriteCount();
            $this->writeWords = $this->_sliceWords($offset, $length);
        }
        return $this->writeWords;
    }

    /**
     * 按offset及lenght返回截取后的数组
     * @param  int $offset 偏移
     * @param  int $lenght 长度
     * @return array         Word
     */
    protected function _sliceWords($offset, $length)
    {
        $totalCount = count($this->getAllWords());
        $length = ($totalCount < ($length + $offset)) ? ($totalCount - $offset) : $length;
        if ($length > 0)
        {
            return array_slice($this->getAllWords(), $offset, $length, true);
        }
        else
        {
            return array();
        }
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function getType()
    {
        return (int)$this->type;
    }


    /**
     * 获取类型的名称
     * @return string 测试类型
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getTypeName()
    {
        if (array_key_exists($this->getType(), $this->titleList))
        {
            return $this->titleList[$this->getType()];
        }

        return '';
    }

    public function getCourse()
    {
        if ($this->Course === null)
        {
            $this->Course = new Course($this->getCourseId());
        }
        return $this->Course;
    }

    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * 获取在当前需要学习的单词总数
     * @return int 
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getPercentWordCount()
    {
        if (null === $this->percentWordCount)
        {
            $this->percentWordCount = 0;
            $this->percentWordCount = $this->computeIndexByPercent($this->getPercent());
        }

        return $this->percentWordCount;
    }

    /**
    测试类型列表
    **/
    public function getTitleList()
    {
        return $this->titleList;
    }
    /**
    最小触发自我测试所学单词
    **/
    public function getMinTaskCount()
    {
        return $this->minTaskCount;
    }
    /**
   获取作答时间分钟
    **/
    public function getTotalMinite()
    {
        return (int)$this->totalMinite;
    }

    /**
     * 设置总共做答时间
     * @param int $totalMinite 分钟
     * panjie
     */
    public function setTotalMinite($totalMinite)
    {
        $this->totalMinite = $totalMinite;
    }
    
    /**
     * 获取本组测试在正常复习时候的首个单词
     * @return Word 
     * @author  panjie 
     */
    public function getFirstWord()
    {
        if ($this->firstWord === null)
        {
            $allWords = $this->getStudyOrderAllWords();
            if (isset($allWords[0]))
            {
                $this->firstWord = $allWords[0];
            }
            else
            {
                $this->firstWord = new Word(0);
            }
        }   
        
        return $this->firstWord;
    }


    /**
     * 获取学生当前要复习的单词
     * @param  Student $Student 学生
     * @return Word           
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getCurrentReviewWord(Student &$Student)
    {
        if (!($Student instanceof Student))
        {
            E('传入变量类型非Student');
        }

        // 获取上次最后一个复习的词
        $reviewNodeWord = $this->getReviewNodeWord($Student);
        if ($reviewNodeWord->getId() == 0)
        {
            return $this->getFirstWord();
        }

        // 判断该单词是否位于本测试的所有的单词列表中
        foreach ($this->getStudyOrderAllWords() as $key => $Word)
        {
            // 处于列表，判断是否为最后一个单词。
            if ($reviewNodeWord->getId() == $Word->getId())
            {
                // 为最后一个单词，则返回本组测试第一个单词
                if ($key == count($this->getStudyOrderAllWords()) - 1)
                {
                    return $this->getFirstWord();
                }

                // 不是最后一个单词，则返回最后一个学习的下一个单词。
                return $Word;
            }
        }

        // 未出现在列表中，则说明还没有开始学习，返回第一个单词。
        return $this->getFirstWord();    
    }

    /**
     * 获取复习节点单词（即上次复习的时候，最后一个复习的单词）
     * @param  Student &$Student 学生
     * @return Word
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getReviewNodeWord(Student &$Student)
    {
        return $this->getCourse()->getCurrentReviewWord($Student);
    }   

    /**
     * 获取学生所有要复习的单词
     * @param  Student &$Student 学生
     * @return array            
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getReviewWords(Student &$Student)
    {
        if (!($Student instanceof Student))
        {
            E('传入变量类型非Student');
        }

        // 获取本组测试全部单词
        $allWords = $this->getStudyOrderAllWords();
        $currentReviewWord = $this->getCurrentReviewWord($Student);

        // 剔除已经复习的
        foreach ($allWords as $key => &$word)
        {
            if ($currentReviewWord->getId() == $word->getId())
            {
                break;
            }
            unset($allWords[$key]);
        }

        return array_values($allWords);
    }

    /**
     * 获取开始的索引号。即本测试是由第几个单词开始的
     * @return   int                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T08:43:41+0800
     */
    public function getBeginIndex()
    {
        if (null === $this->beginIndex) {
            $this->beginIndex = 0;

            // 组测试的话，取上一个组测试的信息
            if (1 === $this->getType()) {
                $map = [];
                $map['type'] = 1;
                $map['percent'] = array('lt', $this->getPercent());
                $map['course_id'] = $this->getCourseId();
                $TestPercentModel = new TestPercentModel();
                $list = $TestPercentModel->field('percent')->where($map)->order('percent desc')->find();
                if (null !== $list) {
                    $this->beginIndex = $this->computeIndexByPercent($list['percent']);
                }
            }
        }
        
        return $this->beginIndex;
    }

    /**
     * 获取结束的索引号，即本测试对应的最后一个单词的序列
     * @return   int                   
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T08:44:34+0800
     */
    public function getEndIndex()
    {
        return $this->getPercentWordCount();
    }


    /**
     * 通过百分比计算出需要学习的单词个数
     * @param    integer                  $percent 百分比 0-100
     * @return   int                            单词个数
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T09:36:31+0800
     */
    public function computeIndexByPercent($percent = 0)
    {
        $index = (int)floor($this->getCourse()->getWordCount() * $percent / 100);
        return $index;
    }
}

