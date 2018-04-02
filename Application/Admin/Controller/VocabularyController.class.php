<?php
/**
 * 词汇管理
 */
namespace Admin\Controller;

class VocabularyController extends AdminController
{
    public function indexAction()
    {
    	$this->display();
    }
   	/**
   	 * 添加词汇
   	 * xulinjie
   	 * @return 
   	 */
    public function addAction()
    {
    	$this->display();
    }
}