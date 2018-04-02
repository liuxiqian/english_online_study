<?php
/*
 * 后台菜单管理页
 * 添加根菜单:addRootMenuAction
 * 添加子菜单:addSonMenuAction
 * 编辑菜单：editMenuAction
 * 删除菜单：deleteMenuAction
 * creat by xuao 2015年7月1日20:46:26
 * 295184686@qq.com
 */
namespace Admin\Controller;

use Menu\Model\MenuModel;
use Admin\Model\Menu\indexModel;
use Admin\Model\Menu\addModel;
use MenuPost\Logic\MenuPostLogic;

class MenuController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        // 进行加密处理，防止上线后对菜单对进行随意的篡改
        // if ( !APP_DEBUG && sha1(md5(I('get.key'))) != '0caa24906591ddbce5e4bb2d2c923edda5a1ad83')
        // {
        //     echo "access denied!";
        //     die();
        // }
    }
    /**
     * 初始化函数，获取菜单列表
     * 调用首页的界面
     * xuao
     * 2015年7月16日18:34:00
     */
    public function indexAction()
    {
        $M = new indexModel();
        $this->assign("M", $M);

        //获取查询关键字
        $keywords = trim(I('get.keywords'));

        //获取菜单列表，并转化为数组
        $menuModel = new MenuModel();
        $menuList = $menuModel->getMenuList($keywords);
        
        $this->assign('data',$menuList);
        $this -> assign('totalCount',$menuModel -> getTotalCount());
        $this->display();
    }

    /**
     * 添加根菜单
     */
    public function addAction(){
        $id = I('get.id',0);
        $data['id'] = $id;
        $title = "添加根菜单";

        $M = new addModel();
        $this->assign("M", $M);

        $this->assign("js",$this->fetch("addJs"));
        $this->assign('menuList',$this->_fetchMenuList());
        $this->assign('data',$data);
        $this->assign('title',$title);
        $this->display();
    }
    /**
     * 添加子菜单，调用的是根菜单的界面
     */
    public function addSonAction(){
        $id = I('get.id',0);
        $data['parent_id'] = $id;
        $title = "编辑菜单";
        $this->assign("js",$this->fetch("addJs"));
        $this->assign('menuList',$this->_fetchMenuList());
        $this->assign('data',$data);
        $this->assign('title',$title);
        $this->display('add');

    }
    /**
     * 编辑菜单，调用的是添加根菜单的界面
     */
    public function editAction(){
        $id = I('get.id');
        $title = "编辑菜单";
        $M = new addModel();
        $this->assign("M", $M);
        
        $menuModel = new MenuModel();
        $data = $menuModel->getMenuById($id);
        $this->assign("js",$this->fetch("addJs"));
        $this->assign('menuList',$this->_fetchMenuList());        
        $this->assign('data',$data);
        $this->assign('title',$title);
        $this->display('add');
    }
    /***
     * 保存，添加或修改之后，提交到该方法
     * 将获取到的Post数据传递给M层
     */
    public function saveAction(){
        //获取post数据
        $data = I('post.');

        $menuModel = new MenuModel();
        $id = $menuModel->saveMenu($data);
        
        if($id === false){
            $this->error('新增失败', U('index',I('get.')));
            return; 
        }

        $MenuPostL = new MenuPostLogic();
        if ($MenuPostL -> saveListsByPostIdsMenuId($data['post'], $id) === false)
        {
            $this->error('写入菜单岗位表错误：' . $MenuPostL->getError(), U('index',I('get.')));
            return; 
        }

        $this->success('新增成功', U('index',I('get.')));
    }
    public function deleteAction(){    
        $id = I('get.id');
        $menuModel = new MenuModel();
        $state = $menuModel->deleteMenu($id);
        if($state){
           $this->success('删除成功', U("index",I('get.'))); 
        }
    }
    /**
     * 取系统菜单列表,用于显示在上级菜单的OPTION
     * @return ARRAY 包括有所有菜单信息的二级数组
     * author:panjie 3792535@qq.com
     */
    private function _fetchMenuList()
    {
        $menuModel = new MenuModel();
        $data = $menuModel->getMenuTree(null, null, 0, 2);
        return tree_to_list($data,0,'_son');
    }
}