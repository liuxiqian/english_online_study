<?php
namespace Home\Controller;

use Home\Model\Course;                 // 课程

class GameController extends HomeController
{
    public function linkLookAction()
    {
        $this->display();
    }

    public function linkLookHomeAction()
    {
        $this->display();
    }

    public function getLinkLookWordsAjaxAction()
    {
        $count = I("get.count");
        $courseId = I("get.courseId");

        $CourseM = new Course($courseId);
        $words = $CourseM->getRandomStarWords($count);
        // dump($words);

        foreach ($words as $key => $word) {
            $randomWords[2*$key]['num'] = 2*$key;
            $randomWords[2*$key]['id'] = $word->getId();
            $randomWords[2*$key]['name'] = $word->getTitle();

            $randomWords[2*$key+1]['num'] = 2*$key+1;
            $randomWords[2*$key+1]['id'] = $randomWords[2*$key]['id'];
            $randomWords[2*$key+1]['name'] = $word->getTranslation();
        }

        shuffle($randomWords);
        // dump($randomWords);
        
        $this->ajaxReturn($randomWords);
    }

    /**
     * 拼写高手 游戏界面
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-17T09:07:24+0800
     */
    public function SpellHomeAction()
    {
        $courseId = I("get.courseId");
        $Course = new Course($courseId);
        if (0 === $Course->getId()) {
            return $this->error('未接收到课程号，未接收的课程号有误');
        }

        $Word = $Course->getOneRandomWord();
        $this->assign('Word', $Word);
        $this->display();
    }

    /**
     * 拼写高手 开始界面
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-17T09:07:35+0800
     */
    public function SpellIndexAction()
    {
        $courseId = I("get.courseId");
        $Course = new Course($courseId);
        if (0 === $Course->getId()) {
            return $this->error('未接收到课程号，未接收的课程号有误');
        }
        
        $this->display();
    }

    /**
     * 获取下一个拼写单词    
     * @return   
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-11-17T16:15:19+0800
     */
    public function getNextSpellWordAjaxAction() {
        $result = array('status'=>'success');

        $courseId = I('get.courseId');
        $Course = new Course($courseId);
        if (0 === $Course->getId()) {
            $result['status'] = 'error';
            $result['message'] = '未接收到课程号，未接收的课程号有误';
            return $this->ajaxReturn($result);
        }

        // 获取一个随机单词
        $Word = $Course->getOneRandomWord();
        $result['data'] = $Word->getJsonData();

        return $this->ajaxReturn($result);
    }
}