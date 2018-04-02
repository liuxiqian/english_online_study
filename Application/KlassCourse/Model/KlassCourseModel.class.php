<?php
namespace KlassCourse\Model;

use Yunzhi\Model\YunzhiModel;

/**
* 班级课程模块
*/
class KlassCourseModel extends YunzhiModel
{
    protected $_validate = array(
        array('klass_id','require','klass_id is required',1),
        array('course_id','require','course_id is required',1),
        );
    
}