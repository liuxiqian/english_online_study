<?php

namespace Home\Model;

/**
 * 每日词汇量
 */
use WordProgressLoginView\Logic\WordProgressLoginViewLogic;//单词进度表

class DayStudyCount extends Statistics
{
    private static $WordProgressLoginViewLogic = NULL;
    private $count = NULL;        //数量
    private $maxCount = 0;        //最大词汇量

    //获取每天的单词数量
    public static function getWordProgressLoginViewLogic()
    {
        if (is_null(self::$WordProgressLoginViewLogic)) {
            self::$WordProgressLoginViewLogic = new WordProgressLoginViewLogic();
        }

        return self::$WordProgressLoginViewLogic;
    }

    public function getCount()
    {
        if (is_null($this->count)) {
            if ($this->isTomorrow()) {
                $this->count = 0;
            } else {
                if ($this->isToday()) {
                    $this->count = $this->_getCount();
                } else {
                    $this->count = Cache::get(__CLASS__, __FUNCTION__, $this->cacheKey);
                    if (FALSE === $this->count) {
                        $this->count = $this->_getCount();
                        Cache::set(__CLASS__, __FUNCTION__, $this->cacheKey, $this->count, 0);
                    }
                }
            }
        }

        return $this->count;
    }

    private function _getCount() {
        //设定每天0点与24点
        $beginTime = strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $this->getDay());
        $endTime = $beginTime + 24 * 60 * 60;

        //取符合条件的个数
        $map['student_id'] = $this->Student->getId();
        $map['time'] = array(array('egt', $beginTime), array('lt', $endTime));
        return $this->getWordProgressLoginViewLogic()->where($map)->count();
    }

    public function getMaxCount()
    {
        return $this->getMaxCount;
    }

    /**
     * 获取当月数据列表
     * @return array(DayStudyCount)
     */
    public function getCurrentMonthAllLists()
    {
        for ($i = 1; $i <= $this->totalDays; $i++) {
            $beginTime = strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $i);
            $lists[] = new DayStudyCount($beginTime, $this->Student);
        }

        return $lists;
    }

}
