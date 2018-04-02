<?php
namespace Home\Controller;
use Home\Model\SelfTest;

class SelfTestController extends HomeController
{
	public function indexAction()
    {
        $Test = new SelfTest($this->Student);
        $this->assign("Test", $Test);
        $this->display();
    }
	public function dictationAction()
	{
		$this->display();
	}
	public function interpretationAction()
	{
		$this->display();
	}
}
