<?php

namespace Student\Logic;

use Student\Model\StudentModel;

class StudentLogic extends StudentModel
{
    //重置密码
    public function resetPassword($studentId)
    {
        if ((int)$studentId === 0)
        {
            $this->error = "系统错误!";
            return false;
        }
        else
        {
            $data               = array();
            $data['id']         = $studentId;
            $data['password']   = C('DEFAULT_PASSWORD');
            return $this->saveList($data);
        }
    }

}
