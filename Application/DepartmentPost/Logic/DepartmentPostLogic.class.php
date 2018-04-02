<?php
/**
 * 部门岗位
 * panjie
 * 2016.04
 */
namespace DepartmentPost\Logic;

use DepartmentPost\Model\DepartmentPostModel;
use Post\Logic\PostLogic;
use Department\Logic\DepartmentLogic;

class DepartmentPostLogic extends DepartmentPostModel
{

	public function addListByDepartmentId($departmentId)
	{
		//取部门信息
		$DepartmentL = new DepartmentLogic();
		$department = $DepartmentL->where(array("id"=>$departmentId))->find();
		if ($department === null)
		{
			$this->setError("The data of id $departmentId not found!");
			return false;
		}

		//取岗位表信息
		$PostL = new PostLogic();
		$map = array("is_son" => $department['is_son']);
		$posts = $PostL->where($map)->select();
		if ($posts === false)
		{
			$this->setError("Get post lists error: " . $PostL->getError());
			return false;
		}

		//依次添加记录
		$data = array();
		$data['department_id'] = (int)$departmentId;
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
}