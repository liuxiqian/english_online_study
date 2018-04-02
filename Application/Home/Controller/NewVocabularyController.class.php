<?php
namespace Home\Controller;
use NewWordWordView\Model\NewWordWordViewModel;
use Home\Model\NewWord;
use Home\Model\Word;
/**
 * 生词
 */
class NewVocabularyController extends HomeController
{
	public function indexAction()
    {
        $NewWordWordViewM = new NewWordWordViewModel();
        $map = array();
        $map['student_id'] = $this->Student->getId();
        $lists = $NewWordWordViewM->addMaps($map)->setOrderBys(array('time'=>'desc'))->getLists();
        $totalCount = $NewWordWordViewM->getTotalCount();

        $words = array();
        foreach ($lists as $list)
        {
            $words[] = new Word($list['word_id']);
        }

        $this->assign("totalCount", $totalCount);
        $this->assign("words", $words);
        $this->display();
    }

    /**
     * 删除
     * @return void 
     */
    public function deleteAction()
    {
        $data['status'] = "ERROR";
        $NewWord = new NewWord(I('get.id'));
        if ($NewWord->remove($this->Student) === false)
        {
            $data['data'] = "删除失败";
        }
        else
        {
            $data['status'] = "SUCCESS";
            $data['data'] = "删除成功";
        }

        $this->ajaxReturn($data);
        //$this->success('操作成功', U('index?id=', I('get.')));
    }
}