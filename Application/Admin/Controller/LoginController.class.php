<?php
/**
 * 登陆后台处理
 */
namespace Admin\Controller;

use Think\Controller;
use User\Logic\UserLogic;
use Admin\Model\Admin\ConstructModel;
use Login\Logic\LoginLogic;

class LoginController extends Controller{
    
    public function indexAction()
    {
        session("user", null);
        session("loginTime", null);
        session("menus", null);
        $this->display();
    }

    //对用户名密码进行判断
    public function loginAction()
    {
        //验证用户名密码
        $UserL = new UserLogic();
        if ($UserL->validate(I('post.')) === false)
        {
            $this->error('用户名密码错误',U('Login/index', I('get.')));
        }
        else
        {

            //获取用户基本信息
            $user = $UserL->getListByUserName(I('post.username'));
            session('user', $user);
            session('loginTime', time());

            //获取用户菜单信息
            $ConstructM = new ConstructModel();
            $ConstructM->setUser($user);
            $menus = $ConstructM->getMenulists();
            session('menus', $menus);

            // 利用session http_referer 进行回跳
            $httpReferer = session('http_referer');
            if ($httpReferer !== null)
            {
                session('http_referer', null);
                header('Location: ' . $httpReferer );
                die();
            }
            else
            {
                //跳转至首页
                $this->success('登录成功',U('Index/index'));
            }
        }
    }

    //注销功能
    public function loginOutAction(){
        
        $this->success('注销成功',U('Login/index'));
    }
}
