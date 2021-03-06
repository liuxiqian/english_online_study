<?php
namespace Home\Model;

use Home\Model\Statistics;
use WordProgressLoginView\Logic\WordProgressLoginViewLogic;
use WordProgressLoginWordCourseView\Model\WordProgressLoginWordCourseViewModel;
/**
 * 每日学习时长
 */
class DayStudyTime extends Statistics
{
    private $minute = null;    // 每天学习分钟数

    /**
     * 获取本类对象的每天学习分钟数
     * @return int
     * @author panjie <panjie@yunzhiclub.com>
     * update: 16.06.07
     */
    public function getMinute()
    {
        if (null === $this->minute)
        {
            if ($this->isTomorrow()) {
                $this->minute = 0;
            } else {
                if ($this->isToday()) {
                    $this->minute = $this->_getMinute();
                } else {
                    $this->minute = Cache::get(__CLASS__, __FUNCTION__, $this->cacheKey);
                    if (FALSE === $this->minute) {
                        $this->minute = $this->_getMinute();
                        Cache::set(__CLASS__, __FUNCTION__, $this->cacheKey, $this->minute, 0);
                    }
                }
            }
        }

        return $this->minute;
    }



    /**
     * 获取本对象对于某一课程的学习总时长
     * @param  Course &$Course 课程
     * @return int          
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getMinuteByCourse(&$Course)
    {
        if (get_class($Course) !== 'Home\Model\Course')
        {
            E('传入的变量非Course');
        }

        if ($this->minuteByCourseId !== $Course->getId())
        {
            $this->minuteByCourseId = $Course->getId();
            $map = array();
            $map['word__course_id'] = $Course->getId();
            $this->minuteByCourse = $this->_getMinute($map);
        } 
        
        return $this->minuteByCourse;
    }

    private function _getMinute($map = array())
    {
        $beginTime = strtotime($this->getYear().'-'.$this->getMonth().'-'.$this->getDay());
        $endTime = $beginTime + 24*60*60;

        $map['login__student_id'] = $this->Student->getId();
        $map['time'] = array(array('egt',$beginTime), array('lt',$endTime));

        //由time找满足有效学习时间的time并求和
        $WordProgressLoginWordCourseViewM = new WordProgressLoginWordCourseViewModel();
        $datas = $WordProgressLoginWordCourseViewM->where($map)->select();

        $timeInterval = C("YUNZHI_TIME_INTERVAL");
        $temp = 0;
        $sum = 0;
        foreach ($datas as $key => $value) 
        {
            $minus = $value['time'] - $temp;
            if($minus <= $timeInterval)  //若两次学习的时间间隔小于合理间隔，则认为是有效学习，计入$sum
            {
                $sum = $minus + $sum;
            }
            $temp = $value['time'];
        }
        unset($WordProgressLoginWordCourseViewM);
        return floor($sum/60+0.5);
    }

    //获取某月每天的本类对象
    public function getCurrentMonthAllLists()
    {
        //根据本月天数实例本类对象
        $lists = array();
        for ($i = 1;$i <= $this->totalDays;$i++)
        {
            $beginTime = strtotime($this->getYear().'-'.$this->getMonth().'-'.$i);
            $lists[] = new DayStudyTime($beginTime,$this->Student);   
        }
        return $lists;
    }

    /**
     * 获取当天起始学习时间
     * @return time
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getBeginTime()
    {
        if (null === $this->beginTime)
        {
            $this->beginTime = $this->_getTime();
            
        }

        return $this->beginTime;
    }

    /**
     * 根据条件获取某一条学习时间
     * @param  string $order asc:第一条，desc：最后一条
     * @param  array  $map   查询条件
     * @return int        时点的时间戳
     * @author panjie <panjie@yunzhiclub.com>
     */
    private function _getTime($order = 'asc', $map = array())
    {
        // 初始化
        $order = $order === 'asc' ? 'asc' : 'desc';
        $orderBy = 'time ' . $order;
        $WordProgressLoginWordCourseViewM = new WordProgressLoginWordCourseViewModel();

        // 取出当天的0点及24点的时间戳, 并进行查询
        $beginTime                  = strtotime(date('Y-m-d', $this->getTime()));
        $endTime                    = $beginTime + 24*60*60;
        $map['time']         = array(array('egt', $beginTime), array('lt', $endTime));
        $map['login__student_id'] = $this->getStudent()->getId();

        $data                       = $WordProgressLoginWordCourseViewM->field('time')->where($map)->order($orderBy)->find();
        unset($WordProgressLoginWordCourseViewM);
        if (null === $data)
        {
            return strtotime('19700101');
        }

        return (int)$data['time'];
    }

    /**
     * 获取当天最后学习的时点
     * @return time 
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getEndTime()
    {

        if (null === $this->endTime)
        {
            $this->endTime = $this->_getTime('desc');
        }

        return $this->endTime;
    }

    /**
     * 获取某课程的当天起始学习时间
     * @param  Course &$Course 课程
     * @return time          
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getCourseBeginTime(&$Course)
    {
        // 判断传入类型
        if (!is_object($Course) || (get_class($Course) !== 'Home\Model\Course'))
        {
            E('传入的类型非Course');
            return;
        }

        $map = array();
        $map['word__course_id'] = $Course->getId();
        return $this->_getTime('asc', $map);
    }

    /**
     * 获取某课程的当天结束时间
     * @param  Course &$Course 课程
     * @return time
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getCourseEndTime(&$Course)
    {
        // 判断传入类型
        if (!is_object($Course) || (get_class($Course) !== 'Home\Model\Course'))
        {
            E('传入的类型非Course');
            return;
        }

        $map = array();
        $map['word__course_id'] = $Course->getId();
        return $this->_getTime('desc', $map);
    }

    /**
     * 获取学习时长列表
     * @param  Student &$Student  学生
     * @param  int $beginTime 开始时间
     * @param  int $endTime   结束时间
     * @return array            this
     * @author panjie <panjie@yunzhiclub.com>
     */
    static public function getLists(&$Student, $beginTime, $endTime)
    {
        // 判断传入类型
        if (!is_object($Student) || (get_class($Student) !== 'Home\Model\Student'))
        {
            E('传入的类型非Student');
            return;
        }

        // 如果结束小于开始，那么对换
        if ($endTime < $beginTime)
        {
            $temp = $beginTime;
            $beginTime = $endTime;
            $endTime = $temp;
        }

        // 根据传入的时间，返回数组
        $result = array();
        while ($beginTime <= $endTime)
        {
            $result[] = new DayStudyTime($endTime, $Student);
            $endTime = $endTime - 24*60*60;
        }

        return $result;
    }

    public function getStudyRecordListsByCourse(Course &$course) {
        return StudyRecord::getAllByCourseStudentTime($course, $this->Student, $this->getDayBeginTime());
    }
}