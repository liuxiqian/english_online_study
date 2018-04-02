<?php
namespace Home\Controller;

use ExpertView\Logic\ExpertViewLogic;   //专家视图
use Think\Controller;
use Home\Model\Student;     // 学生

class LoginController extends Controller
{
    //对用户名密码进行判断
    public function loginAction()
    {
        $username = I('post.username');
        $password = I('post.password');
        $Student = Student::validate($username, $password);
        if ($Student->getId() === NULL)
        {
            $this->error("用户或密码错误", U('index', I('get.')));
            return;
        }

        // 检验用户状态是否正常
        if (0 !== (int)$Student->getStatus())
        {
            $this->error('对不起，您的账户状态不正常，请联系您的教务员以获取帮助.', U('index', I('get.')));
            return;
        }

        // 登录
        Student::login($Student);
        $this->success('登录成功', U('Index/index'));
    }

    //注销功能
    public function logoutAction()
    {
        Student::logOut();
        $this->success('注销成功', U('Login/index'));
    }

    public function checkAjaxAction()
    {
        //检测是否勾选记住密码，传入cookie信息
        if(I('post.remember') == 'true')
        {
            cookie('password',I('post.password'),30*24*60*60);
            cookie('username',I('post.username'),30*24*60*60);
            cookie('remember',true,30*24*60*60);
        }
        else
        {
            cookie('password',null);
            cookie('username',null);
            cookie('remember',null);
        }

        $return = array();
        $UserL = new UserModel();
        $username = trim(I('post.username'));
        $password = trim(I('post.password'));
        switch ($UserL->checkUser($username,$password))
        {
            case '1':
                //根据post的用户名取出用户信息，再将id与name存入session
                $list = $UserL->getUserInfoByName($username);
                session('user_id',$list['id']);
                session('user_name',$list['username']);

                //登录成功后跳转
                $return['state'] = "success";
                $this->ajaxReturn($return);
                break;

            case '0':
                $return['state'] = "error";
                $return['msg'] = "用户名密码错误" ;
                $this->ajaxReturn($return);
                break;

            case '2':
                $return['state'] = "error";
                $return['msg'] = "无此用户名" ;
                $this->ajaxReturn($return);
                break;
        }
    }

    public function indexAction()
    {
        $this->display();
    }
}
