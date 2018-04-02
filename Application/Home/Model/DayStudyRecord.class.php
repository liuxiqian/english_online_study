<?php
/**
 * 每日学习记录
 * xulinjie
 * @return
 */
namespace Home\Model;

use WordProgressLoginView\Logic\WordProgressLoginViewLogic; // 单词进度 登陆信息 视图
use Test\Logic\TestLogic;   // 测试

class DayStudyRecord extends Model {
    private static $WordProgressLoginViewLogic = NULL;
    private $time           = 0;    // 日期
    private $Student        = null; // 学生
    private $cacheKey       = '';   // 缓存key


    public function __construct($time, Student $Student)
    {
        $this->time = strtotime(date("Y-m-d", $time));
        $this->Student = $Student;
        $this->cacheKey = $this->time . '_' . $Student->getId();
    }

    public function getTime()
    {
        return $this->time;
    }

    private function isToday() {
        if ($this->time > time() - 24*60*60) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    public function getNewWordsCount()
    {
        if (is_null($this->newWordsCount)) {
            if ($this->isToday()) {
                $this->newWordsCount = $this->_getCountByIsNew(1);
            } else {
                $this->newWordsCount = Cache::get(__CLASS__, __FUNCTION__, $this->cacheKey);
                if (FALSE === $this->newWordsCount) {
                    $this->newWordsCount = $this->_getCountByIsNew(1);
                    Cache::set(__CLASS__, __FUNCTION__, $this->cacheKey,$this->newWordsCount, 0);
                }
            }
        }
        return $this->newWordsCount;
    }

    public function getOldWordsCount()
    {
        if (is_null($this->oldWordsCount)) {
            if ($this->isToday()) {
                $this->oldWordsCount = $this->_getCountByIsNew(0);
            } else {
                $this->oldWordsCount =Cache::get(__CLASS__, __FUNCTION__, $this->cacheKey);
                if (FALSE === $this->oldWordsCount) {
                    $this->oldWordsCount = $this->_getCountByIsNew(0);
                    Cache::set(__CLASS__, __FUNCTION__, $this->cacheKey, $this->oldWordsCount, 0);
                }
            }
        }
        return $this->oldWordsCount;
    }

    public static function getWordProgressLoginViewLogic() {
        if (is_null(self::$WordProgressLoginViewLogic)) {
            self::$WordProgressLoginViewLogic = new WordProgressLoginViewLogic();
        }

        return self::$WordProgressLoginViewLogic;
    }
    /**
     * 获取学习的单词数
     * @param  integer $isNew 新学 或 复习
     * @return int
     */
    private function _getCountByIsNew($isNew = 1)
    {
        $map = array();
        $map['time'] = array(array('egt',$this->time), array('lt', $this->time + 24*60*60));
        $map['student_id'] = $this->Student->getId();
        $map['is_new'] = $isNew;
        $count = $this->getWordProgressLoginViewLogic()->where($map)->count();
        return $count;
    }

    public function getScore()
    {
        if (is_null($this->score)) {
            if ($this->isToday()) {
                $this->score = $this->_getScore();
            } else {
                $this->score = Cache::get(__CLASS__, __FUNCTION__, $this->cacheKey);
                if (FALSE === $this->score) {
                    $this->score = $this->_getScore();
                    Cache::set(__CLASS__, __FUNCTION__, $this->cacheKey, $this->score, 0);
                }
            }
        }
        return $this->score;
    }

    private function _getScore() {
        $map = array();
        $map['time'] = array(array('egt',$this->time), array('lt', $this->time + 24*60*60));
        $map['student_id'] = $this->Student->getId();
        $TestL = new TestLogic();
        $datas = $TestL->where($map)->field('grade')->select();
        $sum = 0;
        foreach ($datas as $data)
        {
            $sum += $data['grade'];
        }

        if (count($datas)) {
            return (int)$sum/count($datas);
        } else {
            return '-';
        }

    }

    public function getStudent()
    {
        return $this->Student;
    }

    /**
     * 获取全部列表
     * xulinjie
     * @return array() DayStudyRecord
     */
    static public function getAllLists($beginDate = "2016-05-01",$endDate = "2016-05-07",Student $Student)
    {
        // 转化时间戳
        $beginTime = strtotime($beginDate);
        $endTime = strtotime($endDate);
        if ($endTime < $beginTime)
        {
            $temp = $endTime;
            $endTime = $beginTime;
            $beginTime = $temp;
        }

        if ($endTime > time()) {
            $endTime = strtotime(date('Y-m-d'));
        }

        // 数据列表实例化
        $result = array();
        $i = 0;
        while ($endTime >= $beginTime)
        {
            $result[] = new DayStudyRecord($endTime, $Student);
            $endTime -= 24*60*60;
            if (++$i >= 31)  // 最大支持查询31天的数据
                break;
        }

        return $result;
    }
}