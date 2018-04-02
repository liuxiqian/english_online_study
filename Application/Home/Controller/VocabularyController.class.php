<?php
namespace Home\Controller;

use Think\Controller;
use Home\Model\Word;
use Word\Logic\WordLogic;
use NewWord\Logic\NewWordLogic;
use NewWordWordView\Logic\NewWordWordViewLogic;

class VocabularyController extends HomeController
{
    public function indexAction()
    {   
        $page = (int)I('get.p');
        $pageSize = (int)I('get.pagesize') ? (int)I('get.pagesize') : C('yunzhi_page_size');
        $totalCount = 0;

        // 按不同的条件，进行数据的查询 
        if (I('get.title') !== "")
        {
            $Words = Word::getLists($this->Student, I('get.title'));
        }
        else if (I('get.range') === 'studied')
        {
            $Words = Word::getPageStudiedWords($this->Student, $page, $pageSize, $totalCount, I('order'));
        }
        else if (I('get.range') === 'studing')
        {
            $Words = Word::getPageRemainingWords($this->Student, $page, $pageSize, $totalCount, I('order'));
        }
        else
        {
            $Words = Word::getPageWords($this->Student, $totalCount, $page, $pageSize, I('order'));
        }

        // 将本页数据返回
        $this->assign("totalCount", $totalCount);
        
        
        C("YUNZHI_PAGE_SIZE", $pageSize);
        C("YUNZHI_P", $p);

        // 传前台
        $this->assign("words", $Words);
        $this->display();
    }

    private function _sort($Words, $sortby = 'asc')
    {
        $refer = $resultSet = array();
        foreach ($Words as $i => $Word)
           $refer[$i] = $Word->getTitle();
        switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ( $refer as $key=> $val)
           $resultSet[] = &$Words[$key];
        return $resultSet;
    }  


    /**
     * 将单词加入生词本
     */
    public function addToNewWordAjaxAction()
    {        
        $data['status'] = "ERROR";
        $studentId = $this->Student->getId();

        // 拼接查询条件
        $newWord = array();
        $newWord['word_id'] = I('get.id');
        $newWord['student_id'] = $studentId;

        // 有则更新时间，使用在排序中处于首位，无则新增数据
        $NewWordL = new NewWordLogic();
        if (($data = $NewWordL->where($newWord)->find()) !== null)
        {
            $newWord['id'] = $data['id'];
        }

        // 更新数据表
        if ($NewWordL->saveList($newWord) === false)
        {
            $data['data'] = "加入失败".$NewWordL->getError();
            $this->ajaxReturn($data);
            return;
        }
        else
        { 
            $data['status'] = "SUCCESS";
            $data['data'] = "加入成功";
        }
       
        $this->ajaxReturn($data);
    }
}