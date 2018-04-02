<?php
namespace Admin\Controller;

use WordNature\Logic\WordNatureLogic;         // 单词扩展信息
/**
 * 单词扩展属性
 */
class WordNatureController extends AdminController
{
    public function indexAction()
    {
        $WordNatureL = new WordNatureLogic();
        $this->assign("datas", $WordNatureL->getLists());
        $this->display();
    }

    public function addAction()
    {
        $this->assign("title", "新增扩展属性");
        $this->display();
    }

    public function editAction()
    {
        $WordNatureL = new WordNatureLogic();
        $id = I('get.id');
        $this->assign("title", "编辑扩展属性");
        $this->assign("data", $WordNatureL->getListById($id));
        $this->display('add');
    }

    public function saveAction()
    {
        $jumpUrl = U('index?id=', I('get.'));
        $WordNatureL = new WordNatureLogic();
        try
        {
            if ($WordNatureL->saveList(I('post.')) === false)
            {
                $this->error("数据保存错误，错误信息:" . $WordNatureL->getError(), $jumpUrl);
                return;
            }
        }
        catch(\Think\Exception $e)
        {
            $this->error("数据保存错误，错误信息:" . $e->getMessage(), $jumpUrl);
            return;
        }

        $this->success("操作成功", $jumpUrl);
    }

    public function deleteAction()
    {
        $jumpUrl = U('index?id=', I('get.'));
        $WordNatureL = new WordNatureLogic();
        if (false === $WordNatureL->deleteListById(I('get.id')))
        {
            $this->error("数据删除出错，错误信息:" . $WordNatureL->getError, $jumpUrl);
            return;
        }
        $this->error("操作成功", $jumpUrl);
    }
}