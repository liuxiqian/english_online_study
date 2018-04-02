<?php

namespace Admin\Controller;

use User\Logic\UserLogic;	//用户表

class PersonalCenterController extends AdminController
{
	public function indexAction()
	{
		return $this->editAction();
	}

	public function editAction()
	{
		//取用户信息
		$user  = $this->getUser();
		$this->assign('user', $user);
		$this->display('edit');
	}

	/**
	 * 保存密码
	 * @return
	 * liuxi
     * 2016.5
	 */
	public function saveAction()
	{
		try
		{
			//取当前用户信息
			$user = $this->getUser();
			$data = array();
			$list = array();

			//拼接验证数据
			$data['username'] = $user['username'];
			$data['password'] = trim(I('post.password'));
			$UserL 	= new UserLogic();

			if(($data['password']) !== "")
			{
				//验证原密码是否正确
				if ($UserL->validate($data) === false)
				{
					$this->error("原密码错误", U('edit'));
					return;
				}

				//添加新密码
				$data['password'] = I('post.newpassword');

				//新密码是否输入
				if($data['password'] === "")
				{
					$this->error("请输入新密码", U('edit'));
					return;
				}

				//验证两次密码输入值是否一致
				if($data['password']!== I('post.repassword'))
				{
					$this->error("两次密码输入不一致", U('edit'));
					return;
				}
			}
			//更新其他信息
			$data['id'] 			= $user['id'];
			$data['name'] 			= I('post.name');
			$data['phonenumber'] 	= I('post.phonenumber');
			$data['email'] 			= I('post.email');

			//判断是否输入新密码
			$list['newpassword']    = trim(I('post.newpassword'));
			$list['repassword']     = trim(I('post.repassword'));
			if(($data['password']) === ""&&(($list['newpassword'])||($list['repassword']) !== ""))
			{
				$this->error("请输入原密码", U('edit'));
				return;
			}

			//原密码，新密码，确认密码全部为空，销毁密码
			if(($data['password']) === ""&&($list['newpassword']) === ""&&($list['repassword']) === "")
			{
				//销毁密码
				unset($data['password']);
			}

			if ($UserL->saveList($data) === false)
			{
				$this->error("保存错误:" . $UserL->getError(), U('edit'));
				return;
			}
			else
			{
				//重新session.更新用户数据
				$user = $UserL->getListbyId($user['id']);
				session('user', $user);

				$this->success("操作成功!", U('edit'));
			}

		}
		catch(\Think\Exception $e)
		{
			$this->error("系统错误：" . $e->getMessage(), U('index'));
		}

	}

}
