<?php
/**
 * 区域
 */
namespace Department\Model;

use Yunzhi\Model\YunzhiModel;
use DepartmentPost\Logic\DepartmentPostLogic;

class DepartmentModel extends YunzhiModel
{
	protected $_auto 	= array(array("is_son", 1, 3));
	protected $orderBys = array("is_son"=>"asc", "id"=>"desc");

	//重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new DepartmentPostLogic
            );
        }
        return parent::prepareDelete($options);
    }

	/**
	 * 重写delete 增加对是否删除总部信息的判断
	 * @param  array  $options 
	 * @return           
	 */
	public function delete($options = array())
	{
		$temOptions = $this->options;
		$lists = $this->select();
		$this->options = $temOptions;
		foreach ($lists as $list)
		{
			if ((int)$list['is_son'] === 0)
			{
				$this->setError("parent department can't be deleted!");
				return false;
			}
			else
			{
				return parent::delete($options);
			}
		}
	}

	public function saveList($list)
	{
		//1存自己
		$id = parent::saveList($list);
		if ($id === false)
		{
			return false;
		}

		//如果为新建 则添加其它数据
		if ((int)$list['id'] === 0)
		{
			//2存区域岗位关联表
			$DepartmentPostL = new DepartmentPostLogic();
			if ($DepartmentPostL->addListByDepartmentId($id) === false)
			{
				$this->setError("Add departmentpost list error:" . $DepartmentPostL->getError());
				return false;
			}
		}
		
		return $id;
	}
}