<?php
/**
 * 部门管理
 */
namespace Admin\Controller;
use Department\Logic\DepartmentLogic;
use Yunzhi\Model\YunzhiModel;

class DepartmentController extends AdminController
{
    public function indexAction()
    {
    	$DepartmentL = new DepartmentLogic();

        $id = (int)I('get.id');
        // dump($id);
        if($id)
        {
            $map['id'] = $id;
            $maps = $DepartmentL->addMaps($map);
        }

    	$datas = $DepartmentL->getLists();
        // dump($datas);
    	$this->assign("datas", $datas);
    	$this->display();
    }

    public function saveAction()
    {
        $post = I('post.');
    	$DepartmentL = new DepartmentLogic();

    	if ($DepartmentL->saveList(I('post.')) === false){
    		$this->error("保存错误:".$DepartmentL->getError(),U("Department/index?id=",I('get.')));
    	}
    	else{
    		$this->success("操作成功",U("Department/index?id=",I('get.')));
    	}
    }

    public function addAction()
    {
        //获取用户ID
        $departmentId = I('get.id');

        //取用户信息getListById()
        $DepartmentL = new DepartmentLogic();
        $data = $DepartmentL->getListById($departmentId);

        //传给前台
        $this -> assign('data',$data);
        //显示display('add')
        $this -> display('add');
    }

    public function deleteAction()
    {
    	$DepartmentL = new DepartmentLogic();
    	if ($DepartmentL->deleteList(I('get.id')) === false)
    	{
    		$this->error("删除失败：" . $DepartmentL->getError(), U('index?id=', I('get.')));
    		return;
    	}
    	else
    	{
    		$this->success('操作成功', U('index?id=', I('get.')));
    		return;
    	}
    }
}
