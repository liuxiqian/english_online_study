<?php
namespace Admin\Model\Klass;

use Course\Logic\CourseLogic;

/**
* 新增课程小模型
*/
class addCourseModel extends BaseModel
{
    
    public function getNameById($id)
    {
        $CourseL = new CourseLogic();
        $data = $CourseL->getListById($id);
        return $data['title'];
    }
}