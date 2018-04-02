<?php
namespace Home\Controller;

use Home\Model\DayStudyRecord;

/*前台学习情况下的
学习记录
*/
class RecordController extends HomeController
{
	private $times = 604800;
	public function indexAction()
	{
        $beginDate = I('get.beginDate');
        $endDate = I('get.endDate');
        if ($beginDate === "" && $endDate === "")
        {
            $endDate = date("Y-m-d");
            $beginDate = date("Y-m-d", time() - $this->times);
        }
        else if($beginDate === "")
        { 
            $beginDate = date("Y-m-d", strtotime($endDate) - $this->times);
        }
        else if($endDate === "")
        {
            $endDate = date("Y-m-d", strtotime($beginDate) + $this->times);
        }

        // 将值回传给GET
        $_GET['beginDate'] = $beginDate;
        $_GET['endDate'] = $endDate;

        $datas = DayStudyRecord::getAllLists($beginDate, $endDate, $this->Student);

        $this->assign("datas", $datas);
		$this->display();
	}
}