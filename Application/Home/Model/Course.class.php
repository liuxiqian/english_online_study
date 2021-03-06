<?php
/**
 * 课程类
 * xulinjie
 * 2016.04.25
 */

namespace Home\Model;

use Home\Model\Student;
use Attachment\Logic\AttachmentLogic;
use Course\Model\CourseMode;        // 课程
use Course\Logic\CourseLogic;       //课程表
use Word\Model\WordModel;            // 单词
use Word\Logic\WordLogic;           //单词表
use Test\Model\TestModel;           // 测试记录
use TestPercent\Model\TestPercentModel;     // 测试百分比
use KlassCourse\Logic\KlassCourseLogic;     // 班级课程表
use TestStudentTestPercentCourseView\Logic\TestStudentTestPercentCourseViewLogic;
use WordProgressLoginWordCourseView\Logic\WordProgressLoginWordCourseViewLogic;
use StudentWordReviewNodeCourseView\Model\StudentWordReviewNodeCourseViewModel;     // 学生复习单词节点
use RepeatTimesWordView\Model\RepeatTimesWordViewModel;
use StudentWordStudyNodeCourseView\Model\StudentWordStudyNodeCourseViewModel;   // 学生当前学习的节点记录 - 课程视图。记录学习的进度

class Course extends Model
{

    private static $CourseL = NULL;
    private static $allCourses = NULL;
    public $data = ['_class' => __CLASS__];
    private $wordCount = NULL;         // 星级题数
    private $starCount = NULL;         // 测试百分比 Test
    private $Tests = NULL;         // 首个单词
    private $firstWord = NULL;         // 包含单词的ID数组
    private $wordIds = NULL;

    public function __construct($data = NULL)
    {
        if (!is_null($data)) {
            if (is_array($data)) {
                $this->setData($data);
            } else {
                $data = (int)$data;
                $this->setData(self::getCourseL()->where('id=' . $data)->find());
            }
        }
    }

    public static function getCourseL()
    {
        if (is_null(self::$CourseL)) {
            self::$CourseL = new CourseLogic();
        }

        return self::$CourseL;
    }

    /**
     * 获取所有的课程
     * @return array Course
     */
    static public function getAllCourses()
    {
        if (is_null(self::$allCourses)) {
            self::$allCourses = array();
            $lists = self::getCourseL()->select();
            foreach ($lists as $list) {
                self::$allCourses[] = new Course($list);
            }
            unset($lists);
        }

        return self::$allCourses;
    }

    /**
     * 获取本课程的单词列表
     * @return array
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getCacheWordLists()
    {
        if (NULL === $this->cacheWordLists) {
            $this->cacheWordLists = array();
            $cacheName = 'course_' . $this->getId() . '_wordLists';
            $datas = S($cacheName);
            if (!$datas) {
                $WordL = new WordLogic;
                $map = array();
                $map['course_id'] = $this->getId();
                $datas = $WordL->where($map)->select();
                S($cacheName, $datas);
                $this->cacheWordLists = $datas;
                unset($WordL);
            } else {
                $this->cacheWordLists = $datas;
            }
            unset($datas);
        }

        return $this->cacheWordLists;
    }

    /**
     * 获取首个单词
     * @param  Student $Student 学生
     * @return Word
     * panjie
     */
    public function getCurrentStudyWord(Student $Student)
    {
        //取最后一个学习的单词id
        $map['login__student_id'] = $Student->getId();
        $map['word__course_id'] = $this->getId();
        $map['is_new'] = 1;
        $WordProgressLoginWordCourseViewL = new WordProgressLoginWordCourseViewLogic();
        $list = $WordProgressLoginWordCourseViewL->where($map)->order(array('time' => 'desc'))->field('word_id')->find();
        unset($WordProgressLoginWordCourseViewL);

        // 按是否学习来获取当前需要学习的单词
        if ($list !== NULL) {
            $preWord = new Word((int)$list['word_id']);
            $Word = new Word($preWord->getNextId());
            if ($Word->getId() === 0) {
                $Word = $preWord;
            }
            unset($perWord);
        } else {
            $WordM = new WordModel();
            $map = array();
            $map['course_id'] = $this->getId();
            $map['pre_id'] = 0;
            $word = $WordM->field('id')->where($map)->find();
            if ($word === NULL) {
                $Word = new Word(0);
            } else {
                $Word = new Word($word['id']);
            }
        }

        return $Word;
    }

    /**
     * 获取新学单词的总数
     * @param    Student $Student 学生
     * @return   int
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-17T09:51:09+0800
     */
    public function getNewStudyWordsCount($Student)
    {
        $StudentCourse = new StudentCourse($Student, $this);

        return $StudentCourse->getNewStudyWordsCount();
    }

    /**
     * 星级词数，即难度为4星或5星的。
     * @return int
     * panjie
     */
    public function getStarCount()
    {
        return $this->starCount;
    }

    /**
     * 获取当前测试
     * @param    Student &$Student 学生
     * @return   Test                             测试
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T13:35:33+0800
     */
    public function getCurrentTest(Student &$Student)
    {
        $StudentCourse = new StudentCourse($Student, $this);

        return $StudentCourse->getCurrentTest();
    }

    /**
     * 获取某学生是通过了本课程的所有考试。
     * @param    Student &$Student 学生
     * @return   boolen
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T13:35:56+0800
     */
    public function getIsDone(Student &$Student)
    {
        $StudentCourse = new StudentCourse($Student, $this);

        return $StudentCourse->getIsDone();
    }

    /**
     * 本课程关联的测试数据
     * 比如1个前侧 ，2个阶段测，3个组测等
     * @return array Test
     * @author panjie <3792535@qq.com>
     */
    public function getTests()
    {
        if ($this->Tests === NULL) {
            $TestPercentM = new TestPercentModel;
            $lists = $TestPercentM->field("id")->where("course_id=" . $this->id)->order("percent asc")->select();
            unset($TestPercentM);

            $this->Tests = array();
            foreach ($lists as $list) {
                $this->Tests[] = new Test($list['id']);
            }
            unset($TestPercentM);
        }

        return $this->Tests;
    }

    /**
     * 获取进度, 用于后台，前台更直观的显示学习新词与总单词数的比例
     * xulinjie
     * @return int
     */
    public function getProgress(Student $Student)
    {
        //课程进度
        $percent = 0;
        $studentId = $Student->getId();
        $TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();

        //取通过成绩
        if ((int)C('YUNZHI_GRADE') !== 0) {
            $grade = C("YUNZHI_GRADE");
        } else {
            $grade = $TestStudentTestPercentCourseViewL->getGrade();
        }

        //这个学生、这门课程的所有测试记录
        $lists = $TestStudentTestPercentCourseViewL->where(array('student__id' => $studentId, "course__id" => $this->id))->select();

        //测试记录中成绩合格的记录
        foreach ($lists as $key => $value) {
            if ((int)$value['grade'] >= $grade && $value['percent'] > $percent) {
                $percent = $value['percent'];
            }
        }

        unset($TestStudentTestPercentCourseViewL);

        return $percent;
    }

    /**
     * 获取复习单词数
     * xulinjie
     * @return int
     */
    public function getOldStudyWordsCount(Student $Student)
    {
        $StudentCourse = new StudentCourse($Student, $this);
        $count = $StudentCourse->getOldStudyWordsCount();
        unset($StudentCourse);

        return $count;
    }

    /**
     * 判断学生是否对该课程拥有学习的权限
     * @param  Student $Student 学生
     * @return bool
     * panjie
     */
    public function getIsAccess(Student $Student)
    {
        // 看对应的班级是否有该门课程
        $map = array();
        $map['klass_id'] = $Student->getKlass()->getId();
        $map['course_id'] = $this->getId();

        $KlassCourseL = new KlassCourseLogic();
        $count = $KlassCourseL->where($map)->count();
        unset($KlassCourseL);

        if ($count == 0) {
            return FALSE;
        }

        // 判断学生是否冻结
        if (0 !== (int)$Student->getStatus()) {
            return FALSE;
        }

        // 判断学生是否过期
        if (TRUE === (bool)$Student->getIsExpire()) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 随机获取 $count 个难词
     * @param  int $count 获取个数
     * @return array        word
     * panjie
     */
    public function getRandomStarWords($count)
    {
        $lists = $this->_getAllStarWords();
        $length = count($lists);
        $count = $count > $length ? $length : $count;
        $words = array_rand($lists, $count);
        $result = array();
        foreach ($words as $word) {
            $result[] = new Word($lists[$word]['id']);
        }

        return $result;
    }

    /**
     * 获取所有的星级（难）题
     * @return   array
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-17T09:06:11+0800
     */
    public function _getAllStarWords()
    {
        if ($this->_allStarWords === NULL) {
            $map = array();
            $map['star'] = array("gt", 2);
            $map['course_id'] = $this->getId();
            $WordL = new WordLogic();
            $this->_allStarWords = $WordL->where($map)->field("id")->select();
            unset($WordL);
        }

        return $this->_allStarWords;
    }

    /**
     * 获取一个随机单词
     * @return   Word
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-17T09:03:19+0800
     */
    public function getOneRandomWord()
    {
        $count = $this->getWordCount();
        $offset = rand(0, $count - 1);
        $WordL = new WordLogic();
        $word = $WordL->field("id")->limit($offset, 1)->select();
        unset($WordL);

        return new Word($word[0]['id']);
    }

    /**
     * 单词总数
     * @return int
     * panjie
     */
    public function getWordCount()
    {
        if ($this->wordCount === NULL) {
            $this->wordCount = $this->getWordCountById($this->getId());
        }

        return $this->wordCount;
    }

    /**
     * @param $courseId
     * @return mixed
     * Create by panjie@yunzhiclub.com
     * 获取某个课程的单词总数
     */
    static public function getWordCountById($courseId)
    {
        $map = array();
        $map['course_id'] = $courseId;
        $count = WordLogic::getCurrentWordLogic()->where($map)->count();

        return $count;
    }

    /**
     * 获取所有难词
     * @return  array Word
     * @author  panjie
     */
    public function getAllStarWords()
    {
        if ($this->allStarWords === NULL) {
            $words = $this->_getAllStarWords();

            $this->allStarWords = array();
            foreach ($words as $word) {
                $this->allStarWords[] = new Word($word['id']);
            }
        }

        return $this->allStarWords;
    }

    /**
     * 获取测试的最高成绩
     * @return int
     * panjie
     */
    public function getLastScore(Student $Student)
    {
        $TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic;
        $map = array();
        $map['student__id'] = $Student->getId();
        $map['course__id'] = $this->getId();

        $best = $TestStudentTestPercentCourseViewL->field('grade')->order("grade desc")->where($map)->find();
        if ($best === NULL) {
            return 0;
        } else {
            return (int)$best['grade'];
        }
    }

    /**
     * 获取当前
     * @param  Student $Student [description]
     * @return [type]           [description]
     */
    public function getNextTest(Student &$Student)
    {
        return $this->_getTestByType($Student, 'next');
    }

    /**
     * 通过类型 获取测试信息 获取当前的测试信息，或是监近的测试信息
     * @param  Student $Student 学生
     * @param  string $type current 当前测试 , next 下一测试节点
     * @return Test
     * @author  panjie
     */
    private function _getTestByType(Student $Student, $type = 'current')
    {
        // 对类型进行判断
        if (!is_object($Student) || (get_class($Student) !== 'Home\Model\Student')) {
            E('传入的变量类型非Student对象');
        }

        $TestPercentM = new TestPercentModel;

        $grade = (int)C('YUNZHI_GRADE') > 0 ? C('YUNZHI_GRADE') : 80;
        $percent = $this->getProgressPercent($Student);

        // 未开始学习，则看是否返回学前测信息
        if (!$percent) {
            //查找学前测, 找到则按条件返回，找不到，则默认没有学前测
            $map = array();
            $map['type'] = 0;
            $map['course_id'] = $this->getId();
            $list = $TestPercentM->where($map)->find();

            if ($list !== NULL) {
                // 判断用户是否有学前测的记录，没有则返回
                $map = array();
                $map['test_percent_id'] = $list['id'];
                $map['student_id'] = $Student->getId();
                $TestM = new TestModel;
                $test = $TestM->where($map)->find();
                if ($test === NULL) {
                    unset($TestM);
                    unset($TestPercentM);

                    return new Test($list['id']);
                }
            }
        }

        if ($type === 'current') {
            // 找测试的结点，即从小于等于该节点的数据中，找到最大的那个值
            $map = array();
            $map['percent'] = array("elt", $percent);
            $map['course_id'] = $this->getId();
            $map['type'] = array("neq", '0');
            $list = $TestPercentM->where($map)->order('percent desc')->find();

            // 为了防止在同一个测试百分比上存在两个不同类型的测试，需要遍历一下测试
            $lists = array();
            if (NULL !== $list) {
                $map['percent'] = $list['percent'];
                $lists = $TestPercentM->where($map)->order('percent desc')->select();
            }
            unset($TestPercentM);

            // 根据测试的结点，查找成绩，如果成绩未达标，则返回该测试结点
            $map = array();
            $map['student_id'] = $Student->getId();
            $TestM = new TestModel;
            foreach ($lists as $list) {
                $map['test_percent_id'] = $list['id'];
                $listTemp = $TestM->where($map)->order("grade desc")->find();
                if ($listTemp === NULL) {
                    unset($TestM);

                    return new Test($list['id']);
                } elseif ((int)$listTemp['grade'] < (int)$grade) {
                    unset($TestM);

                    return new Test($list['id']);
                }
            }
            unset($TestM);
        } else if ($type === 'next') {
            $map = array();
            $map['course_id'] = $this->getId();
            $map['percent'] = array("gt", $percent);
            $map['type'] = array("neq", '0');
            $TestPercentM = new TestPercentModel;
            $test = $TestPercentM->where($map)->order('percent asc')->find();
            unset($TestPercentM);

            if (isset($test['id'])) {
                return new Test((int)$test['id']);
            }
        }

        // 没有满足条件的记录，则返回默认测试信息
        return new Test(0);
    }

    /**
     * 按学习单词的个数，计算学习百分比
     * @param  Student $Student 学生
     * @return int           百分比
     * @author  panjie <3792535@qq.com>
     */
    public function getProgressPercent(Student $Student)
    {
        $StudentCourse = new StudentCourse($Student, $this);

        return $StudentCourse->getProgressPercent();
    }

    /**
     * 获取课程的最后一组测试信息
     * 即获取本课程百分比最大的那个
     * @return Test
     * @author panjie
     */
    public function getLastTest()
    {
        $map = array();
        $map['course_id'] = $this->getId();
        $TestPercentM = new TestPercentModel;
        $list = $TestPercentM->field("id")->where($map)->order('percent desc')->find();
        if ($list == NULL) {
            return new Test(0);
        } else {
            return new Test($list['id']);
        }
    }

    /**
     * 通过测试类型值获取测试的数量
     * @param  int $type 0前侧 1组测 2阶段测
     * @return int
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getCountByTestType($type)
    {
        if ($this->countByTestTypeValue !== $type) {
            $this->countByTestTypeValue = $type;
            $this->countByTestType = 0;
            $TestPercentM = new TestPercentModel();
            $map['course_id'] = $this->getId();
            $map['type'] = $type;
            $this->countByTestType = $TestPercentM->where($map)->count();
            unset($TestPercentM);
        }

        return $this->countByTestType;
    }

    /**
     * @return array|mixed|null
     * Create by panjie@yunzhiclub.com
     * 获取本课程中所有的单词id
     */
    public function getWordIds()
    {
        if (NULL === $this->wordIds) {
            $storeKey = __CLASS__ . '_' . __METHOD__ . '_' . $this->getId();
            $this->wordIds = S($storeKey);
            if (FALSE === $this->wordIds) {
                $this->wordIds = array();
                $WordM = new WordModel;
                $map['course_id'] = $this->getId();
                $lists = $WordM->field('id')->where($map)->select();
                foreach ($lists as $key => &$list) {
                    $this->wordIds[] = $list['id'];
                }
                S($storeKey, $this->wordIds);
                unset($lists);
                unset($WordM);
            }
        }

        return $this->wordIds;
    }

    /**
     * 取首个单词
     * @return   Word                   [description]
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-11T10:17:39+0800
     */
    public function getFirstWord()
    {
        if (NULL === $this->firstWord) {
            $WordModel = new WordModel;
            $map['course_id'] = $this->getId();
            $order = array('order' => 'asc', 'id' => 'asc');
            $field = array('id');
            $data = $WordModel->field($field)->where($map)->order($order)->find();
            if (NULL === $data) {
                $this->firstWord = new Word(0);
            } else {
                $this->firstWord = new Word($data['id']);
            }
        }

        return $this->firstWord;
    }

    /**
     * 未获取读音文件的单词数量
     * @return int
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getUnFetchedAudioCount()
    {
        if (NULL === $this->unFetchedAudioCount) {
            $this->unFetchedAudioCount = 0;
            foreach ($this->getWords() as &$word) {
                if (!$word->getIsUkAudioFileExist() || !$word->getIsUkAudioFileExist()) {
                    $this->unFetchedAudioCount++;
                }
            }
        }

        return $this->unFetchedAudioCount;
    }

    /**
     * 获取本课程中的所有单词
     * @return array Word
     * @author panjie
     */
    public function getWords()
    {
        if (NULL === $this->words) {
            $storeKey = __CLASS__ . '_' . __METHOD__ . '_' . $this->getId();
            $this->words = S($storeKey);
            if (FALSE === $this->words) {
                $this->words = array();
                $WordM = new WordModel;
                $map['course_id'] = $this->getId();
                $lists = $WordM->field('id')->where($map)->select();
                foreach ($lists as $key => &$list) {
                    $this->words[] = new Word($list['id']);
                }
                S($storeKey, $this->words);
                unset($lists);
                unset($WordM);
            }

        }

        return $this->words;
    }

    /**
     * 获取没有音频文件的单词列表
     * @return array Word
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getUnFetchedAudioWords()
    {
        if (NULL === $this->unFetchedAudioWords) {
            $this->unFetchedAudioWords = array();
            foreach ($this->getWords() as &$word) {
                if (!$word->getIsUkAudioFileExist() || !$word->getIsUkAudioFileExist()) {
                    $this->unFetchedAudioWords[] = $word;
                }
            }
        }

        return $this->unFetchedAudioWords;
    }

    /**
     * 获取学生当前课程复习到的单词
     * @param  Student $Student 学生
     * @return Word
     * @author panjie
     */
    public function getCurrentReviewWord(Student &$Student)
    {
        $StudentCourse = new StudentCourse($Student, $this);

        return $StudentCourse->getCurrentReviewWord();
    }

    /**
     * 获取重复的单词列表
     * 按重复次数，将计算好以后的数据做为数组返回
     * @param  Student &$Student 学生
     * @return array()
     */
    public function getRepeatWordLists(Student &$Student)
    {
        // 按条件进行查询
        $RepeatTimesWordViewM = new RepeatTimesWordViewModel;
        $map['student_id'] = $Student->getId();
        $map['word__course_id'] = $this->getId();
        $lists = $RepeatTimesWordViewM->where($map)->select();
        unset($RepeatTimesWordViewM);

        // 按重复次数，重新拼接新数组
        $result = array();
        foreach ($lists as &$list) {
            for ($i = 0; $i < $list['times']; $i++) {
                $result[] = $list['word_id'];
            }
        }
        unset($lists);

        // 返回
        return $result;
    }


    /**
     * 获取附件URL信息
     * @return string
     */
    public function getAttachmentUrl()
    {
        try
        {
            $attachmentId = $this->getAttachmentId();

            if ($attachmentId != 0) {
                $AttachmentL = new AttachmentLogic();
                return $AttachmentL->getUrlById(14192);
            }
            return "null";
        }
        catch(\Think\Exception $e)
        {
            echo "getAttachmentUrl error" . $e->getMessage();
            return;
        }
        catch(\Exception $e)
        {
            echo "getAttachmentUrl error" . $e->getMessage();
            return;
        }
        
    }    
}