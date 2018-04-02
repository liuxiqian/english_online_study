<?php
/**
*学习榜样
*liuxi
*/
namespace Home\Controller;

use Home\Model\Hero;
use Student\Model\StudentModel;

class HeroController extends HomeController
{

	public function indexAction()
	{
        $Hero = new Hero($this->Student->getId());
        $this->assign('Hero',$Hero);
        $this->display();
	}

    /**
     * 改变学习榜样是否为自己
     * @return  void
     * @author  panjie 
     */
    public function setHeroIsSelfAjaxAction()
    {
        $result = array('status'=>"SUCCESS");
        try
        {
            $type = (int)I('get.type') ? 1 : 0;
            $Hero = new Hero($this->Student->getId());
            $Hero->setHeroIsSelf($type);
        }
        catch(\Think\Exception $e)
        {
            $result['status'] = 'ERROR';
            $result['message'] = $e->getMessage();
        }

        $this->ajaxReturn($result);
    }

    /**
     * 改变榜样
     * @return json
     * @author  panjie 
     */
    public function toggleHeroAjaxAction()
    {
        $heroId = I('get.id');
        $Hero = new Hero($this->Student->getId());
        $Hero->toggleHero($heroId);
        return;
    }
}
