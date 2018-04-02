<?php
/**
* 学生学习单词进度
*/
namespace WordProgressLoginView\Logic;

use WordProgressLoginView\Model\WordProgressLoginViewModel;

class WordProgressLoginViewLogic extends WordProgressLoginViewModel
{
    protected $timeInterval = 120;  //有效学习时间间隔。我们认为，当学习两个单词间的时间大于 有效学习时间间隔 时，不记入有效学习时间。 当学习两个单词的间隔小于等于 有效学习时间间隔时，记入有效学习时间
    
    public function __construct()
    {
        // 进行有效学习时间间隔的初始化
        if ((int)C("YUNZHI_TIME_INTERVAL") !== 0)
        {
            $this->timeInterval = (int)C("YUNZHI_TIME_INTERVAL");
        }
        parent::__construct();
    }

    /**
     * 获取某个学生的在某次登陆的学习时长 
     * @param  int $studentId 学生ID
     * @param  int $loginId 登陆ID
     * @return int 学习时长（分）
     */
    public function getTimeCostByStudentIdLoginId($studentId, $loginId)
    {
        // 获取所有符合要求的的学习记录，按学习时间 排序
        $map['login_id'] = $loginId;
        $map['student_id'] = $studentId;
        return $this->_getSumTimeByMap($map);
    }

    /**
     * 获取某个学生的总共学习时间
     * 计算方法同本类中的  getLastTimeCostByStudentIdLoginId
     * @param  int $studentId 学生ID  
     * @return int           学习时长（分）
     */
    public function getTotalTimeCostByStudentId($studentId)
    {
        // 获取所有符合要求的的学习记录，按学习时间 排序
        $map['student_id'] = $studentId;
        return $this->_getSumTimeByMap($map);
    }

    /**
     * 获取 一定条件 下的总共有效学习时间
     * @param  array $map 查谒条件
     * @return int      学习时长(分)
     */
    private function _getSumTimeByMap($map)
    {
        $datas = $this->where($map)->order("time",'desc')->select();
        $sum = 0;                       //该学生有效总学习时间
        $temp = 0;      //循环初值
        foreach ($datas as $key => $value) 
        {
            $minus = $value['time'] - $temp;
            if($minus <= $this->timeInterval)  //若两次学习的时间间隔小于合理间隔，则认为是有效学习，计入$sum
            {
                $sum = $minus + $sum;
            }
            $temp = $value['time'];
        }
        
        // 返回总学习时长
        if(floor($sum/60) > 0){
            return floor($sum/60);
        }
        else{
            return 0;
        }
    }

    /**
     * 获取某个学生学习的新词总数
     * @param  int $studentId 
     * @return int           
     */
    public function getNewWordCountByStudentId($studentId)
    {
        $map = array("is_new" => "1");
        $map['student_id'] = (int)$studentId;
        return (int)$this->where($map)->count();
    }
    
    /**
     * 获取某个学生复习的单词总数
     * @param  int $studentId 学生ID
     * @return INT            
     */
    public function getOldWordCountByStudentId($studentId)
    {
        $map = array("is_new" => "0");
        $map['student_id'] = (int)$studentId;
        return $this->where($map)->count();
    }
}