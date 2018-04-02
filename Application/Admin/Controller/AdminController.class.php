<?php
namespace Admin\Controller;

use Think\Controller;
use Admin\Model\Admin\ConstructModel;
use Menu\Logic\MenuLogic;					//菜单
use UserMenuView\Logic\UserMenuViewLogic;
use MenuPost\Logic\MenuPostLogic;     //
use Admin\Model\Log;					// 日志
use Admin\Model\User;					// 用户
use Home\Model\Teacher;					// 教师

class AdminController extends Controller
{
	protected $User = null;
	protected $Teacher = null;
	
	public function __construct()
	{
		parent::__construct();

		$user 		= session("user");
		
		$loginTime 	= session("loginTime");

		//判断登陆状态, 判断未操作的时间
		if ($user === null || (time() - $loginTime > 30*60))
		{
			session('http_referer', $_SERVER['HTTP_REFERER']);
			redirect_url(U('Login/index'));
			die();
		}
		else
		{
			session("user", $user);
			session('loginTime', time());
		}

		$this->User = new User($user['id']);
		$this->Teacher = new Teacher($user['id']);
		session("User", $this->User);
		
		// 写入日志
		$path = dirname(THINK_PATH) . C('YUNZHI_LOG_PATH');
		$Log = new Log(C('YUNZHI_LOG_RECORDS'), $path, $user);
		$Log->write();

		//取当前ACTION，判断是否存在于菜单表中，不存在，开发模式时，直接跳转到菜单管理的添加
		//非开发模式时，直接跳转到报错界面
		$MenuL = new MenuLogic();
		if (!$menu = $MenuL->getCurrentMenu())
		{
			if (APP_DEBUG)
			{
				$this->redirect('Menu/add', array("module" => MODULE_NAME, "controller" => CONTROLLER_NAME, "action" => ACTION_NAME), 3, 'Plase add the action in Menu Management');
				exit();
			}
			else
			{
				$this->error("你访问的界面不存在", U('Index/index'));
				exit();
			}
		}

		//取左侧菜单数据
		$ConstructM = new ConstructModel();
		$ConstructM->setUser($user);

		//看session中是否存在菜单信息，不存在，则获取。存在，则传入小M.
		$menus = null;
		if (!APP_DEBUG)
		{
			$menus = session("menus");
		}

		if ($menus === null)
		{
			$menus  = $ConstructM->getMenuLists();
		}
		$ConstructM->setMenus($menus);
//		dump($menus);
//		exit();
		//判断用户是否拥有该ACTION的权限
		if ($ConstructM->isMenuAllowed() === false)
		{
			$this->error("对不起，您无此操作权限", U('Index/index'));
			return;
		}
		
		$this->assign("ConstructM", $ConstructM);
		$this->assign("User", $this->User);

		//取左侧菜单
		$tpl = T("Admin@Admin/nav");
		$YZ_TEMPLATE_NAV = $this->fetch($tpl);
		$this->assign("YZ_TEMPLATE_NAV", $YZ_TEMPLATE_NAV);
	}
 

	protected function getUser()
	{
		$user = session('user');
		if ($user === null)
		{
			redirect_url(U('Login/index'));
			die();
		}
		else{
			return $user;
		}
	}
}