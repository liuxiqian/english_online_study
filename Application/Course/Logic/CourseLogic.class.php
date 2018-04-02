<?php
/**
 * 课程管理
 */
namespace Course\Logic;

use Course\Model\CourseModel;
use TestPercent\Logic\TestPercentLogic;
use Attachment\Logic\AttachmentLogic;//附件

class CourseLogic extends CourseModel
{
    public function addListByCourseId($courseId)
    {
        //取表信息
        $TestPercentL = new TestPercentLogic();
        $map = array("type" => "0||2");
        $testPercents = $TestPercentL->where($map)->select();
        if ($testPercents === false)
        {
            $this->setError("Get testPercents lists error: " . $TestPercentL->getError());
            return false;
        }

        //依次添加记录
        $data = array();
        $data['course_id'] = (int)$courseId;
        foreach ($posts as $post)
        {
            $data['post_id'] = $post['id'];
            if ($this->saveList($data) === false)
            {
                return false;
            }
        }
    }

    public function deleteListsByDepartmentId($id)
    {
        $id = (int)$id;
        $map = array();
        $map['department_id'] = $id;
        try
        {
            return $this->where($map)->delete();
        }
        catch(\Think\Exception $e)
        {
            $this->setError("Delete list error:" . $e->getMessage());
            return false;
        }
    }

     /**
     * 获取附件URL信息
     * @return string
     */
    public function getAttachmentUrl($attachmentId)
    {
        try
        {
            $AttachmentL = new AttachmentLogic();
            return $AttachmentL->getUrlById($attachmentId);
        }
        catch(\Think\Exception $e)
        {
            echo "getAttachmentUrl error" . $e->getMessage();
            return;
        }
        catch(\Exception $e)
        {
            echo "getAttachmentUrl error" . $e->getMessage();
            return;
        }
        
    }    

}