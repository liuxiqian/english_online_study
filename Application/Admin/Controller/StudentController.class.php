<?php
/**
 * 学生
 */
namespace Admin\Controller;

use Student\Logic\StudentLogic;   //课程
use Admin\Model\Student\BaseModel;
use Card\Logic\CardLogic; //卡密
use Home\Model\Student;//前台学生类
use Home\Model\Klass;   // 班级

class StudentController extends AdminController
{
    public function indexAction()
    {
        $user = $this->getUser();
        $Student = new Student();
        $this->assign("Student",$Student);
        $this->assign("Klasses", Klass::getAllOfCurrentUser());
        $M = new BaseModel();
        $M->setUserId($user['id']);
        C('YUNZHI_PAGE_SIZE', I('get.pagesize') ? (int)I('get.pagesize') : C('yunzhi_page_size'));
        $this->assign("M",$M);
        $this->display();      
    }

    public function addAction()
    {
        //先getUser,获得当前用户
        $user = $this->getUser();

        
        //设置当前用户
        $M = new BaseModel();
        $M->setUserId($user['id']);

        //传到V层
        $this->assign("M",$M);
        $this->display('add');
        return;
    }

    public function editAction()
    {
        //获取学生id
        $studentId = I('get.id');

        //先getUser,获得当前用户
        $user = $this->getUser();
        
        //设置当前用户
        $M = new BaseModel();
        $M->setUserId($user['id']);

        $this->assign('studentId', $studentId);
        $this->assign("M",$M);
        $this->display('edit');
    }

    public function saveAction()
    {
        $jumpUrl = U('index?id=', I('get.')); // 跳转地址
        $data = I('post.');//表单信息
        $CardL = new CardLogic();//为更新card表
        $StudentL = new StudentLogic();//为更新学生表

        // 判断是否为添加
        if ((int)$data['id'] === 0) {

            // 较验卡号密码是否正确
            if (($cardId = $CardL->validate($data['number'], $data['password'])) === false) {
                $this->error("校验卡密失败" . $CardL->getError(), $jumpUrl);
                return;
            }

            //添加的话取返回的id
            $data['password'] = C('DEFAULT_PASSWORD');
            if (($id = $StudentL->saveList($data)) === false)
            {
                $this->error("保存错误:", $StudentL->getError, $jumpUrl);
                return;
            }

            //添加学生id到card表
            if ($CardL->updateListByIdWithStudentId($cardId, $id) === false)
            {
                $this->error("更新卡密信息错误, 学生未成功激活", $jumpUrl);
                return;
            }

            
        }
        // 当前为更新操作
        else
        {
            if ($StudentL->saveList($data) === false)
            {
                $this->error("保存错误:", $StudentL->getError, $jumpUrl);
                return;
            } 
        }

        $this->success("操作成功", $jumpUrl);
        return;
    }

    //删除学生
    public function deleteAction()
    {
        //取id
        $studentId= I('get.id');

        $StudentL = new StudentLogic();
        if($StudentL->deleteList($studentId) === false)
        {
           $this->error("删除失败：" . $StudentL->getError(), U('index?id=', I('get.')));
            return;
        }
        else
        {
            $this->success('操作成功', U('index?id=', I('get.')));
            return;
        }
    }

    //冻结学生
    public function frozenAction()
    {

        //获取学生id修改该学生的状态
        $studentId = I('get.id');
        $M = new BaseModel();
        $list = $M->getStudentByStudentId($studentId);
        if ($list['status'] == 0) {
            $list['status'] = 1;
        }
        else{
            $list['status'] = 0;
        }
        //更新学生信息
        $StudentL = new StudentLogic();
        if ($StudentL->saveList($list) === false)
        {
            $this->error("操作失败：" . $StudentL->getError(), U('index?id=', I('get.')));
            return;
        } 
        else
        {
            $this->success('操作成功', U('index?id=', I('get.')));
            return;
        }   
    }

    //重置密码
    public function resetPasswordAction()
    {
        $studentId = I('get.id');
        $StudentL = new StudentLogic();
        $status = $StudentL->resetPassword($studentId);
        if($status !== false)
        {
            $this ->success('您的密码已重置，新密码为:' . C('DEFAULT_PASSWORD'), U('index?id=', I('get.')));
            return;
        }
        else
        {
            $this -> error("重置失败",U('index?id='.I('get.')));
            return;
        }
    }

    //验证卡密账号和密码
    public function validateAjaxAction()
    {
        $number = I('get.number');
        $password = I('get.password');
        $data = array();
        $data['status'] = 'ERROR';
        $CardL = new CardLogic();//去卡密表中验证
        if(($CardL->validate($number, $password)) === false)
        {
            $data['data'] = $CardL->getError();
        }

        else
        {
            $data['status'] = 'SUCCESS';
        }

        $this->ajaxReturn($data);
    }

}