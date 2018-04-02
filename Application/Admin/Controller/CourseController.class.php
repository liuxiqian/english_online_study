<?php
/**
 * 课程
 * 魏静云
 */
namespace Admin\Controller;

use Course\Logic\CourseLogic;   //课程
use TestPercent\Logic\TestPercentLogic;  //组测试百分比
use Admin\Model\Course\BaseModel;
use Home\Model\Course;
use Attachment\Logic\AttachmentLogic;   //附件

class CourseController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $M = new BaseModel();
        $this->assign("M", $M);
    }
    
    public function indexAction()
    {
        //传到前台
        $this->display();
        return;
    }

    public function editAction()
    {
        $this->addAction();
    }

    public function addAction()
    {
        $CourseL = new CourseLogic();
        $course = $CourseL->getListById(I('get.id'));
       
        if ($course === false)
        {
            $course = array("id"=>null);
        }

        if ($course['attachment_id'] != 0) {
            $url = $CourseL->getAttachmentUrl($course['attachment_id']);
            
            $this->assign('url', $url);
        }

        $this->assign('list', $course);
        $this->display('add');
    }

    public function saveAction()
    {
        $data = I('post.');
        $CourseL = new CourseLogic();
        
        if ($CourseL->saveListTest($data) === false)
        {
            $this->error("数据保存发生错误" . $CourseL->getError(), U('index?id=', I('get.')));
            return;
        }
        else
        {
            $this->success("操作成功", U('index?id=', I('get.')));
        }
    }

    public function deleteAction()
    {
        //取id
        $courseId= I('get.id');

        $CourseL = new CourseLogic();
        if($CourseL->deleteList($courseId) === false)
        {
           $this->error("删除失败：" . $CourseL->getError(), U('index?id=', I('get.')));
            return;
        }
        else
        {
            $this->success('操作成功', U('index?id=', I('get.')));
            return;
        }
    }

    /**
     * 查看未抓取到读音的单词
     * @return [type] [description]
     * @author  panjie <panjie@yunzhiclub.com>
     */
    public function unFetchedAudioAction()
    {
        // 获取当前课程信息
        $courseId = I('get.id');
        $Course = new Course($courseId);
        if (0 == $Course->getId())
        {
            $this->error('您所请求的参数错误');
            return;
        }

        $this->assign('Course', $Course);
        $this->display();
    }

    /**
     * 上传文件
     * @return json data
     * xulinjie
     * 2017.03
     */
    public function uploadAjaxAction()
    {
        $AttachmentL = new AttachmentLogic();
        $action = "uploadimage";
        $this->ajaxReturn($AttachmentL->upload($action));
    }
}