<?php
namespace Home\Controller;
/*
前台学习情况下的
统计分析
*/
use Home\Model\DayStudyTime;
use Home\Model\DayStudyCount;
use Home\Model\DayGrade;

class AnalysisController extends HomeController
{
	
	public function indexAction()
	{
        //判断是否有get.time信息
        $time =I('get.time')?strtotime(I('get.time')):time();
        
        //将时间戳传入DayStudeyTime DayStudyCount DayGrade类    
        $DayStudyTime = new DayStudyTime($time,$this->Student);
        $DayStudyCount = new DayStudyCount($time,$this->Student);
        $DayGrade = new DayGrade($time,$this->Student);


        //传入V层DayStudyTime和DayStudyTime和DayGrade
        $this->assign('DayStudyTime', $DayStudyTime);
        $this->assign('DayStudyCount', $DayStudyCount);
        $this->assign('DayGrade', $DayGrade);
        $this->assign('time', $time);
	$this->display();
	}
}