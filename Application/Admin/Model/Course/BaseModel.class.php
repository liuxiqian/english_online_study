<?php
namespace Admin\Model\Course;

use TestPercent\Logic\TestPercentLogic;
use Word\Logic\WordLogic;
use Course\Logic\CourseLogic;   //课程
use Home\Model\Course;          // 课程

class BaseModel
{
    protected $totalCount = 0;      // 数据总数
    public $attachmentId = null;

    public function getLists()
    {
        if (null === $this->lists)
        {
            $this->lists = array();
            $CourseL = new CourseLogic();
            $lists = $CourseL->getLists();
            $this->totalCount = $CourseL->getTotalCount();
            foreach ($lists as $list)
            {
                $this->lists[] = new Course($list['id']);
            }
            unset($lists);
            unset($CourseL);
        }
        
        return $this->lists;
    }

    public function getTotalCount()
    {
        return $this->totalCount;
    }
     
}