<?php
/**
 * admin 根类
 */
namespace Admin\Model\Admin;

use Menu\Logic\MenuLogic; 	//菜单
use UserMenuView\Logic\UserMenuViewLogic;

class ConstructModel
{
	protected $menuLists = null; //菜单列表
	protected $breadCrumbs = null; 	//当前菜单对应的面包屑
	protected $user = null;			//当前用户
	protected $menus = null;		//用户当前菜单
	protected $userMenuLists = null;		//用户拥有的菜单权限列表
	protected $UserMenuViewL;		//用户菜单视图

	public function __construct()
	{
		$this->UserMenuViewL = new UserMenuViewLogic();
		$this->MenuL = new MenuLogic();
	}

	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}
	public function getUserName()
	{
		return $this->user['name'];
	}
	
	public function setMenus($menus)
	{
		$this->menus = $menus;
	}

	public function getMenuLists($module = "Admin")
	{

		if ($this->menus !== null)
		{
			return $this->menus;
		}
		
		$this->menus = $this->MenuL->getListByIsDev($module);

		//比较菜单列表和用户权限列表
		//去掉用户没有权限的menu列表
		foreach ($this->menus as $key => $menu) {
			if(($this->_checkMenu($menu['id'], $this->getUserMenuLists())) === false)
			{
				unset($this->menus[$key]);
			}
		}
		return $this->menus;
	}

	/**
	 * 检测MENUID 是否存在于目录树中 
	 * @param  int $menuId    菜单ID
	 * @param  tree $menuTrees 目录树
	 * @return 存在返回true            不存在返回false
	 */
	private function _checkMenu($menuId, $menuTrees)
	{
		$menuId = (int)$menuId;
		foreach ($menuTrees as $menuTree)
		{
			if ((int)$menuTree['menu_id'] === $menuId)
			{
				return true;
			}
			else if(is_array($menuTree['_son']))
			{
				return $this->_checkMenu($menuId, $menuTree['_son']);
			}
		}
		return false;
	}


	public function getUserMenuLists()
	{
		if ($this->userMenuLists !== null)
		{
			return $this->userMenuLists;
		}
		else
		{
			// 根据当前用户id取用户权限menu列表
			$maps = array("id" => $this->user['id']);
			$this->userMenuLists = $this->UserMenuViewL->where($maps)->select();
			return $this->userMenuLists;
		}
	}

	public function isMenuAllowed()
	{
		$currentMenu = $this->MenuL->getCurrentMenu();
		//判断用户是否拥有当前菜单的权限
		if ( ((int)$currentMenu['development'] === 0) && !in_array_by_key($currentMenu['id'], $this->getUserMenuLists(), "menu_id"))
		{
			return false;
		}		
		else
		{
			return true;
		}
	}



	/**
	 * 获取面包屑数据
	 * 返回的数组中，第0个数据，是当前菜单数据
	 * @return lists 
	 */
	public function getBreadCrumbs()
	{
		if ($breadCrumbs === null)
		{
			$this->breadCrumbs = $this->MenuL->getBreadCrumbs();
		}
		return $this->breadCrumbs;
	}

	/**
	 * 检测传入的菜单LIST是否位于整个面包屑上
	 * @param   $list 
	 * @return 是返回true 否false       
	 * panjie 2016-01
	 */
	public function checkIsCurrent($list)
	{
		//不存在id则直接返回
		if (!isset($list['id']))
		{
			return false;
		}

		//获取面包屑信息并遍历，如果找到值，返回true，否则false
		$id = $list['id'];
		$breadCrumbs = $this->getBreadCrumbs();
		foreach($breadCrumbs as $key => $value)
		{
			if ($value['id'] == $id)
			{
				return true;
			}
		}

		return false;

	}

}