<?php
namespace Home\Controller;

use Home\Controller\HomeController;
use Home\Model\Article;             // 阅读闯关
/**
*
*/
class ArticleController extends HomeController
{
    public function indexAction()
    {
        $id = (int)I('get.id');
        $Article = new Article($id);
        if (!$Article->getId())
        {
            $this->error('传入数据有误,或该阅读闯关被删除，请联系管理员');
            return;
        }

        $this->assign('Article', $Article);
        $this->display();
    }
}

