<?php
namespace Home\Controller;

use Attachment\Logic\AttachmentLogic;   // 附件
use Think\Controller;

class PersonalController extends HomeController
{
	public function indexAction()
    {
        $this->display();
    }


    /**
     * 上传头像
     * @return json 
     * @author  panjie 
     */
    public function uploadAjaxAction()
    {
        // 调用附件L
        $AttachmentL = new AttachmentLogic();

        // 设置上传类型并上传
        $action = "uploadimage";
        $result = $AttachmentL->upload($action);

        // 将返回的结果写入 学生
        if (isset($result['id']))
        {
            $data = array();
            $data['attachmentId'] = $result['id'];
            try
            {
                $this->Student->update($data);
            }
            catch(\Think\Exception $e)
            {
                $this->ajaxReturn(array('status'=>'ERROR', 'message'=>'写入学生信息错误.'));
                return;
            }
        }
        
        // 返回信息
        $this->ajaxReturn($result);
    }

    /**
     * 更新用户信息
     * @return josn 返回json数据
     * @author  panjie 
     */
    public function saveAjaxAction()
    {
        $errors = array();
        $result = array(
            'status' => 'SUCCESS');

        // 关闭令牌验证
        C('TOKEN_ON', false);

        // 数据传入Student 进行更新操作，并记录返回值
        $data = json_decode(file_get_contents('php://input'), true);
        try
        {
            if (!$this->Student->update($data))
            {
                $result['status'] = 'ERROR';
                $result['message'] = '数据更新错误';
            }
        }
        catch(\Think\Exception $e)
        {
            $result['status'] = 'ERROR';
            $result['message'] = $e->getMessage();
        }

        // 返回前台
        $this->ajaxReturn($result);
    }
}