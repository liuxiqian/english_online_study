<?php
namespace Home\Controller;

use Home\Model\Course;      // 课程
use Home\Model\StudentCourse;   // 学生课程
/*
前台学习情况下的
统计分析
*/
class WordhomeController extends HomeController
{
	public function __construct()
    {
        parent::__construct();
        // 判断用户是否冻结
        if (0 !== (int)$this->Student->getStatus())
        {
            $this->error('对不起，您的账户状态不正常，请联系您教务员.', U('Index/index'));
                return;
        }

        // 判断用户是否过期
        if ($this->Student->getIsExpire())
        {
            if($this->Student->getIsExpire() === true){
                $this->error("对不起，您的账户有效期至:" . date("Y-m-d", $this->Student->getDeadLine()) . '。现已过期，请联系您的教务员', U('Index/index'));
                return;
            }
        }

        // 判断用户是否拥有该课程
        $Course = new Course(I('get.id'));
        if (!$Course->getIsAccess($this->Student))
        {
            $this->error("对不起，您无权学习该课程.", U('Index/index'));
            die();
        }
        $this->Course = $Course;
    }

	public function indexAction()
	{
        $this->StudentCourse = new StudentCourse($this->Student, $this->Course);
        $this->Test = $this->StudentCourse->getCurrentTest(); 

        // 如果是测试环节，将宽度设置为3。记忆词汇环节，宽度设置为2
        if ($this->Test->getId() === 0)
            $this->width = 2;
        else
            $this->width = 3;

        $this->isStudyShow = 0;  // 是否显示记忆词汇

        // 当前不存在测试信息，且课程未完成时，显示词汇记忆
        $isDone = $this->StudentCourse->getIsDone();

        if ($this->Test->getId() == 0 && !$isDone)
        {
            $this->isStudyShow = 1;
        }

        // 当前存在测试信息时，显示 测试按钮
        $this->isTestShow = 0;
        if ($this->Test->getId() != 0)
        {
            $this->isTestShow = 1;
        }

        // 当存在测试信息或是课程完成时，显示复习按钮
        $this->isReviewShow = 0;
        if (($this->Test->getId() != 0 && $this->Test->getType() != 0) || $isDone)
        { 
            $this->isReviewShow = 1;
        }

		$this->display();
	}
}