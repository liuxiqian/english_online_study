<?php
/**
 * 学习详情
 * User: panjie
 * Date: 17/6/9
 * Time: 下午1:17
 */

namespace Home\Model;


use WordProgressLoginWordCourseView\Logic\WordProgressLoginWordCourseViewLogic;

/**
 * @property mixed|null course
 * @property mixed|null student
 * @property mixed|null time
 * 分阶段记录的 学习记录 在后台管理中的：进度查询 -> 学习记录 中应用
 * @author panjie
 */
class StudyRecord extends Model
{
    const INTERVAL = 900;
    protected $newStudyWordsCount;
    protected $oldStudyWordsCount;
    private $cacheKey = NULL;       // 缓存key
    protected $words = NULL;          // 在本阶段学习单词的详情集。在何时学习了什么单词，是复习还是新习
    public $data = ['_class' => __CLASS__];

    /**
     * 学习记录 每中断15分钟，记一次学习记录 constructor.
     * @param Course $course
     * @param Student $student
     * @param $time 本学习记录的起始时间
     * @author panjie
     */
    public function __construct(Course $course, Student $student, $time)
    {
        $this->setData('course', $course);
        $this->setData('student', $student);
        $this->setData('time', $time);
        $this->cacheKey = $course->getId() . '_' . $student->getId() . '_' . $time;
    }

    /**
     * @param $word 某个单词
     * @return $this
     * Create by panjie@yunzhiclub.com
     * 添加单词学习详情
     * @author panjie
     */
    public function addItem($word) {
        if (is_null($this->words)) {
            $this->words = [];
        }
        array_push($this->words, $word);
        return $this;
    }

    /**
     * @param Course $course
     * @param Student $student
     * @param 开始的时间戳
     * @return array
     * Create by panjie@yunzhiclub.com
     * 获取某课程 某学生 某起始时间后24小时内的学习详情记录
     */
    static public function getAllByCourseStudentTime(Course $course, Student $student, $time) {
        // 查找学习记录表, 找出大于传入时间的24小时的学习记录。
        $map = [];
        $map['word__course_id'] = $course->getId();
        $map['login__student_id'] = $student->getId();
        $map['time'] = [['egt', $time],['lt', $time + 24*60*60]];

        // 如果是历史数据，则进行缓存处理
        if (self::isBeforeToday($time)) {
            $cacheKey = $course->getId() . '_' . $student . '_' . $time;
            $lists = Cache::get(__CLASS__, __FUNCTION__, $cacheKey);
            if (FALSE === $lists) {
                $lists = WordProgressLoginWordCourseViewLogic::getCurrentObject()->where($map)->order('time asc')->select();
                Cache::set(__CLASS__, __FUNCTION__, $cacheKey, $lists, 0);
            }
        } else {
            $lists = WordProgressLoginWordCourseViewLogic::getCurrentObject()->where($map)->order('time asc')->select();
        }

        // 按时间段分别实例化 学习记录StudyRecord
        $studyRecords = [];
        if (!empty($lists)) {
            // 15分未连续学习，记录一次学习记录
            $bashTime = $lists[0]['time'];
            $studyRecord = new self($course, $student, $bashTime);
            $studyRecord->setEndtime($bashTime); // 记录最后的学习时间

            // 分段查询记录，并实例化本类，最终传入数组
            foreach ($lists as $list) {
                if (($list['time'] - self::INTERVAL) > $bashTime) {
                    $studyRecord->setEndtime($bashTime);
                    array_push($studyRecords, $studyRecord);
                    $studyRecord = new self($course, $student, $list['time']);
                }
                $studyRecord->addItem($list);
                $bashTime = $list['time'];
            }
            $studyRecord->setEndtime($bashTime);
            array_push($studyRecords, $studyRecord);
        }

        return $studyRecords;
    }

    /**
     * @return int
     * Create by panjie@yunzhiclub.com
     * 获取新学单词数
     */
    public function getNewStudyWordsCount() {
        return $this->_getStudyWordsCountsByIsNew();
    }

    /**
     * @return bool|int
     * Create by panjie@yunzhiclub.com
     * 获取复习单词数
     */
    public function getOldStudyWordsCount() {
        return $this->_getStudyWordsCountsByIsNew(0);
    }

    /**
     * @param int $isNew
     * @return int
     * Create by panjie@yunzhiclub.com
     * 获取新学或复习的单词数
     */
    private function _getStudyWordsCountsByIsNew($isNew = 1) {
        $count = 0;
        foreach ($this->words as $word) {
            if ((int)$word['is_new'] === (int)$isNew) {
                $count ++;
            }
        }
        return $count;
    }

    /**
     * @return float
     * Create by panjie@yunzhiclub.com
     * 获取有效学习时间
     */
    public function getEffectiveMinutes() {
        return $this->getEffectiveMinutesByWords($this->words);
    }

    static public function getEffectiveMinutesByWords($words, $timeKey = 'time') {
        $timeInterval = C("YUNZHI_TIME_INTERVAL");
        $sum = 0;
        if (!empty($words)) {
            $temp = $words[0][$timeKey];
            foreach ($words as $key => $value)
            {
                $minus = $value[$timeKey] - $temp;
                if($minus <= $timeInterval)  //若两次学习的时间间隔小于合理间隔，则认为是有效学习，计入$sum
                {
                    $sum = $minus + $sum;
                }
                $temp = $value[$timeKey];
            }
        }
        return floor($sum/60+0.5);
    }
}