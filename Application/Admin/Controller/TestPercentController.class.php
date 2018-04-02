<?php
namespace Admin\Controller;

use Home\Model\Course;  // 课程
use Home\Model\Test;     // 测试
use TestPercent\Logic\TestPercentLogic;     // 测试百分比（阶段测试）
/**
 * 组测试
 */
class TestPercentController extends AdminController
{
    public function indexAction()
    {
        $courseId = I('get.courseId');
        $Course = new Course($courseId);
        $this->assign('Course', $Course);
        $this->display();
    }

    public function editAction()
    {
        $Test = new Test(I('get.id'));
        $this->assign("Test", $Test);
        $this->display();
    }

    public function saveAction()
    {
        // 更新操作
        $TestPercentL = new TestPercentLogic();
        $TestPercentL->saveList(I('post.'));
        $this->success("操作成功", U('index?id=', I('get.')));
    }

    public function deleteAction()
    {
        // 删除操作
        $TestPercentL = new TestPercentLogic();
        $id = I('get.id');
        if (!$TestPercentL->where("id=$id")->delete())
        {
            $this->error("删除发生错误：" . $TestPercent->getError(), U('index?id=', I('get.')));
        }
        else
        {
            $this->success("操作成功", U('index?id=', I('get.')));
        }
    }
}