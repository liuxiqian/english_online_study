<?php
namespace Home\Model;

/**
 * 统计分析
 */
class Statistics
{
    protected $time       = 0;                  // 日期
    protected $year       = 2016;               // 年
    protected $month      = 05;                 // 月
    protected $day        = 01;                 // 日
    protected $totalDays  = 30;                 // 当月总天数
    protected $preMonthDate = "2016-04-01";     // 上月
    protected $nextMonthDate = "2016-05-01";    // 下月
    protected $cacheKey   = null;               // 缓存key
    protected $Student    = null;               // 学生

    public function __construct($time, Student $Student)
    {
        $this->time         = $time;
        $this->year         = date("Y", $this->time);
        $this->month        = date("m", $this->time);
        $this->day          = date("d", $this->time);
        $this->totalDays    = date("t", $this->time);
        $this->Student      = $Student;
        $this->cacheKey = $this->year . $this->month . $this->day . '_' . $Student->getId();
    }

    public function isToday() {
        if (strtotime($this->year . $this->month . $this->day) === strtotime(date('Ymd'))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function isTomorrow() {
        if (strtotime($this->year . $this->month . $this->day) > strtotime(date('Ymd'))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getTotalDays()
    {
        return $this->totalDays;
    }

    public function getStudent()
    {
        return $this->Student;
    }

    public function getPreMonthDate()
    {
        $today = date("Y-m-d", $this->getTime());
        return date("Y-m-d",strtotime("$today -1 month"));
    }

    public function getNextMonthDate()
    {
        $today = date("Y-m-d", $this->getTime());
        return date("Y-m-d",strtotime("$today +1 month"));
    }

    /**
     * @return false|int
     * Create by panjie@yunzhiclub.com
     * 获取今天0点的时间戳
     */
    public function getDayBeginTime() {
        return strtotime(date('Y-m-d', $this->getTime()));
    }
}
