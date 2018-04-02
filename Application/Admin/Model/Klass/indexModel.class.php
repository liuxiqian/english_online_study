<?php
namespace Admin\Model\Klass;

use Student\Logic\StudentLogic;
/**
* 班级管理小模型
*/
class indexModel extends BaseModel
{   
    public function getCountById($id)
    {
        $map = array('klass_id' => $id);
        $StudentL = new StudentLogic();
        $a = $StudentL->where($map)->count();
        return $a;
    }
}