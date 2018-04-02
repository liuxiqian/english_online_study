<?php
/**
 * 前台Studycontroller
 * xulinjie
 * 2106.04.25
 */
namespace Home\Controller;

use Home\Controller\HomeController;

use Home\Model\Word;                                        // 单词类
use Home\Model\Test;                                        // 测试
use Home\Model\Login;                                       // 登陆信息
use Home\Model\Course;                                      // 课程类
use Home\Model\NewWord;                                     // 生词类
use Home\Model\StudentTest;                                 // 学徨测试
use Home\Model\StudentCourse;                               // 学生课程类

use Word\Logic\WordLogic;                                   // 单词表
use StudentWord\Model\StudentWordModel;                     // 学习复习结点信息
use WordProgress\Model\WordProgressModel;                   // 学习进程
use NewWordWordView\Logic\NewWordWordViewLogic;
use StudentWordView\Model\StudentWordViewModel;             // 学习复习结点视图信息
use StudentWordStudyList\Model\StudentWordStudyListModel;   // 重复进行学习的列表
// 学生学习所有单词时的学习节点表
use StudentWordReviewNodeAll\Model\StudentWordReviewNodeAllModel;   
use WordProgressLoginWordCourseView\Logic\WordProgressLoginWordCourseViewLogic;


class StudyController extends HomeController
{
    private function checkStudentIsExpire() {
        // 判断用户是否过期
        if($this->Student->getIsExpire() === true){
            $this->error("对不起，您的账户有效期至:" . date("Y-m-d", $this->Student->getDeadLine()) . '。现已过期，请联系您的教务员', U('Index/index'));
            return;
        }
    }

    /**
     * 课程学习
     * xulinjie
     */
    public function indexAction()
    {
        // 判断用户是否过期
        $this->checkStudentIsExpire();

        //从课程进入，get课程id
        //实例化课程类和学生课程类
        $courseId = I('get.courseId');
        $Course = new Course($courseId);
        $StudentCourse = new StudentCourse($this->Student, $Course);
        $Word = $StudentCourse->getNextStudyWord(new Word(0));
        if (0 === $Word->getId()) {
            $this->error('您已经学完本课程或您还未通过相应的测试');
            return;
        }

        // 最后一次有学习记录的登陆情况
        $studiedRecordLogin = Login::getLastStudiedRecord($this->Student);

        $this->assign('studiedRecordLogin', $studiedRecordLogin);
        $this->assign('Word', $Word->getJsonData($this->Student));
        $this->assign("Course",$Course);
        $this->assign("StudentCourse",$StudentCourse);
        $this->assign('url', U("Study/getNextStudyWordAjax"));
        $this->assign('Test', new Test());
        $this->display();
    }

    /**
     * 获取下一个要学习的单词
     * @param    integer                  $wordId   刚刚学习的单词
     * @param    integer                  $courseId 课程ID
     * @param    string                   $type     学习类型 认识:know 不认识:unknow
     * @return   word:json                             
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-13T15:54:44+0800
     */
    public function getNextStudyWordAjaxAction($wordId = 0, $courseId = 0, $type = 'know', $isNew = 0)
    {
        $data = [];
        try {
            //赋值返回
            $data["status"] = "SUCCESS";
            $nextWord = $this->getNextStudyWord($wordId, $courseId, $type, $isNew);
            $data["data"] = $nextWord->getJsonData();
        } catch (\Exception $e) {
            $data["status"] = "ERROR";
            $data['message'] = $e->getMessage();
        }

        $this->ajaxReturn($data);
        return;
    }

    /**
     * 从复习课程进入
     * xulinjie
     */
    public function reviewWordAction()
    {
        // 判断用户是否过期
        $this->checkStudentIsExpire();

        //从课程进入，get课程id
        //实例化课程类和学生课程类
        $courseId = I('get.courseId');
        $Course = new Course($courseId);
        $StudentCourse = new StudentCourse($this->Student,$Course);

        // 取测试信息
        $Test = $StudentCourse->getCurrentTest();

        // 如果不存在当前测试信息，证明现在没有处于测试结点上。
        // 可能的情况是，用户已经完成了本课的所有的测试，则我们取当前课程的最后一组测试信息。
        if ($Test->getId() === 0)
        {
            $Test = $Course->getLastTest();
        }

        $StudentTest = new StudentTest($this->Student, $Test);
        // 最后一次有学习记录的登陆情况
        $studiedRecordLogin = Login::getLastStudiedRecord($this->Student);
        $this->assign('studiedRecordLogin', $studiedRecordLogin);

        // 传入课程及学生课程对象（其实传入学生课程就可以了，然后在学生课程中去定义get方法来获取学生或是课程信息。）
        $this->assign("Course",$Test->getCourse());
        $this->assign("StudentCourse", $StudentCourse);

        $this->assign('Test',$Test);
        $Word = $StudentTest->getCurrentReviewWord();

        $this->assign("Word", $Word->getJsonData($this->Student));
        $this->assign('url', U('Study/getNextReviewWordAjax'));
        $this->display("index");
    }

    /**
     * 课程学习的ajax
     * xulinjie
     * @param $wordId现在的提交的单词id
     * $type单词的学习状态（0认对；1认错；2拿不准认对）
     * @return json
     */
    public function nextWordAjaxAction($wordId = 0, $nextWordId = 0, $type = null)
    {
        if ($wordId == 0) {
            $data["status"] = "ERROR";
            $Word = new word(0);
            $data["data"] = $Word->getJsonData();
        }
        else
        {
            $Word = new Word((int)$wordId);
            $nextWord = new Word((int)$nextWordId);

            //实例化课程类和学生课程类
            $StudentCourse = new StudentCourse($this->Student,$Word->getCourse());

            //赋值返回
            $data["status"] = "SUCCESS";
            $data["data"] = $StudentCourse->getNextWord($Word, $nextWord, $type)->getJsonData($this->Student);
        }

        $this->ajaxReturn($data);

    }

    /**
     * 设置复习的次数，用于课程复习，学生每复习一个，我们的复习次数就直接1
     * 我们将拿不准之类的东西，放到前台来执行
     * xulinjie
     * @param $wordId现在的提交的单词id
     * @return json
     */
    public function setReviewWordAjaxAction($wordId, $nextWordId, $type = null)
    {
        $result = array('status'=>'SUCCESS');

        // 判断传入的单词ID是否合法，防止数据库中写入无课程或是没有单词记录的WORDID 
        $Word = new Word(I('get.wordId'));
        $nextWord = new Word(I('get.nextWordId'));

        if ($Word->getId() === 0)
        {
            $result['status'] = 'ERROR';
            $result['message'] = '未找到ID为' . $wordId . '的单词';
            $this->ajaxReturn($result);
            return;
        }

        // 实例化 学生课程
        $StudentCourse = new StudentCourse($this->Student, $Word->getCourse());

        // 返回下一个复习的单词
        $result['data'] = $StudentCourse->getNextReivewWord($Word, $nextWord, $type)->getJsonData();

        $this->ajaxReturn($result);
    }

    /**
     * 取下一个生词
     * xulinjie
     * @return json
     */
    public function nextNewWordAjaxAction()
    {
        //实例化生词类
        $NewWord = new NewWord();

        $data["status"] = "SUCCESS";
        $data["data"] = $NewWord->getNextWord($this->Student)->getJsonData();
        $this->ajaxReturn($data);
    }

    /**
     * 提示用户学习结束，或进行测试或进行学习
     * @param  课程ID $courserId 
     * @return   根据学生是否学完本课程，进行不同的跳转
     * panjie
     */
    public function reviewAction($courseId)
    {
        $Course = new Course(I('get.courseId'));
        $this->assign('Course', $Course);
        if ($Course->getIsDone($this->Student))
        {
            $this->reviewDone($Course);
        }
        else
        {
            $this->reviewDoing($Course);
        }
    }

    /**
     * 学生学完本课程
     * @param  Course $Course 课程
     * @return          
     * @author  panjie 
     */
    public function reviewDone($Course)
    {
        // 对类型进行判断
        if (!is_object($Course) || (get_class($Course) !== 'Home\Model\Course'))
        {
            E('传入的变量类型非Course对象');
        }

        $this->display('reviewDone');
    }

    /**
     * 学生正在学习本课程
     * @param  Course $Course 课程
     * @return          
     * @author  panjie 
     */
    public function reviewDoing($Course)
    {
        // 对类型进行判断
        if (!is_object($Course) || (get_class($Course) !== 'Home\Model\Course'))
        {
            E('传入的变量类型非Course对象');
        }

        $this->assign("Test", $Course->getCurrentTest($this->Student));
        
        $this->display('reviewDoing');
    }

    /**
     * 星级题学习
     * @return  
     * @author   panjie <3792535@qq.com>
     */
    public function starWordAction()
    {
        $this->breadCrumbTitle = '难词';
        $wordId = I('get.wordId');
        $Word = new Word($wordId);
        if ($Word->getId() === 0)
        {
            E('传入的单词ID有误');
        }
        $this->assign('Word', $Word);
        $this->assign('breadCrumbTitle', '难词');

        $this->display();
    }

    /**
     * 获取下一个要学习的单词
     * @param    integer                  $wordId   刚刚学习的单词
     * @param    integer                  $courseId 课程ID
     * @param    string                   $type     学习类型 认识:know 不认识:unknow
     * @return   word               
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-14T15:54:44+0800
     */
    public function getNextStudyWord($wordId = 0, $courseId = 0, $type = 'know', $isNew = 0)
    {
        // 判断传入的课程ID是否正确
        $Course = new Course($courseId);
        if (0 === $Course->getId())
        {
            throw new \Exception('can not find the courseId of ' . $courseId, 1);
        } 

        // 构建 学生课程 对象
        $StudentCourse = new StudentCourse($this->Student, $Course);
        $type = ($type === 'know') ? 'know' : 'unknow';
        return  $StudentCourse->getNextStudyWord(new Word((int)$wordId), $type, $isNew);
    }

    /**
     * 获取下一个需要复习的单词 （AJAX）
     * @param    integer                  $wordId 当前学习的单词ID
     * @param    string                   $type   认识'know' 其它:'unknow'
     * @param    integer                  $testId 测试ID
     * @return   Word ajax                           单词
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T13:32:52+0800
     */
    public function getNextReviewWordAjaxAction($wordId = 0, $type = 'know', $testId = 0)
    {
        $data = [];
        try {
            //赋值返回
            $data["status"] = "SUCCESS";
            $data["data"] = $this->getNextReviewWord($wordId, $testId, $type)->getJsonData();
        } catch (\Exception $e) {
            $data["status"] = "ERROR";
            $data['message'] = $e->getMessage();
        }

        $this->ajaxReturn($data);
        return;
    }

    /**
     * 获取下一个需要复习的单词
     * @param    integer                  $wordId   单词ID
     * @param    integer                  $testId   测试ID
     * @param    string                   $type     认识"know" 其它:'unknow'
     * @param    boolean                  $isUpdate 是否进行进度的更新
     * @return   Word                             单词
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-18T13:33:34+0800
     */
    public function getNextReviewWord($wordId = 0, $testId = 0, $type = 'know', $isUpdate = true)
    {
        // 判断传入的测试ID是否正确
        $Test = new Test($testId);
        if (0 === $Test->getId())
        {
            throw new \Exception('can not find the testId of ' . $testId, 1);
        } 

        // 构建 学生课程 对象
        $StudentTest = new StudentTest($this->Student, $Test);
        $type = ($type === 'know') ? 'know' : 'unknow';
        return  $StudentTest->getNextReviewWord(new Word((int)$wordId), $type, $isUpdate);
    }

    /**
     * 用户由『全部词汇』点击单词进行学习
     * @param    integer                  $wordId 单词id
     * @return   html                           
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-26T15:41:22+0800
     */
    public function allwordsReviewAction($wordId = 0)
    {
        $wordId = (int)$wordId;
        $Word = new Word($wordId);
        if (0 === $Word->getId()) {
            return $this->error('传入的参数有误');
        } 

        // 将用户点击的单词 存入 用户正在学习的单词
        $StudentWordReviewNodeAllModel = new StudentWordReviewNodeAllModel();
        $StudentWordReviewNodeAllModel->setNowStudyWord($wordId, $this->Student->getId());

        // 获取课程及学生课程信息
        $Course = $Word->getCourse();
        $StudentCourse = new StudentCourse($this->Student, $Course);
        
        // 传入课程及学生课程对象（其实传入学生课程就可以了，然后在学生课程中去定义get方法来获取学生或是课程信息。）
        $this->assign("Course", $Course);               // 获取当前学习进度
        $this->assign("StudentCourse", $StudentCourse); // 用于获取今日新学与复习的单词数

        $this->assign('Test', new Test);
        $this->assign("Word", $Word->getJsonData($this->Student));
        $this->assign('url', U("Study/getNextReviewWordOfAllWordsAjax"));
        $this->display("index");
    }

    /**
     * 获取 全部词汇 学习时，下一个学习的单词
     * @param    integer                  $wordId 单词id
     * @return   ajax                           
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-26T16:47:34+0800
     */
    public function getNextReviewWordOfAllWordsAjaxAction($wordId = 0, $type = 'know', $testId = 0)
    {
        $data = [];
        try {
            //赋值返回
            $data["status"] = "SUCCESS";

            // 取需要进行二次学习的单词
            $StudentWordStudyListModel = new StudentWordStudyListModel;
            $Word = new Word($wordId);
            if (0 !== $Word->getId()) {
                $StudentWordStudyListModel->computeAndSetNextAppearTime($Word, $this->Student, $type);
            }

            // 获取复习列表中当前需要学习的单词
            $nowWord = $StudentWordStudyListModel->getNowStudyWord($this->Student);

            // 学习列表中当前不需要进行单词学习，则取当前课程的下一单词
            if (0 === $nowWord->getId()) {
                $StudentWordReviewNodeAllModel = new StudentWordReviewNodeAllModel();

                // 取出下一个要学习的单词
                $nowWord = $StudentWordReviewNodeAllModel->getNextStudyWord($this->Student->getId());

                // 设置当前正在学习的单词
                $StudentWordReviewNodeAllModel->setNowStudyWord($nowWord->getId(), $this->Student->getId());

                unset($StudentWordReviewNodeAllModel);
            }   

            unset($StudentWordStudyListModel);
            $data["data"] = $nowWord->getJsonData();
        } catch (\Exception $e) {
            $data["status"] = "ERROR";
            $data['message'] = $e->getMessage();
        }

        $this->ajaxReturn($data);
        return;
    }

    /**
     * 复习生词。由生词界面，点击单词进行
     * @param    integer                  $wordId 单词id
     * @return   html                           
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-27T10:36:04+0800
     */
    public function newWordsReviewAction($wordId = 0) 
    {
        $wordId = (int)$wordId;
        $Word = new Word($wordId);
        if (0 === $Word->getId()) {
            return $this->error('传入的参数有误');
        } 

        // 将用户点击的单词 存入 用户正在学习的单词
        $StudentWordReviewNodeAllModel = new StudentWordReviewNodeAllModel();
        $StudentWordReviewNodeAllModel->setNowStudyWord($wordId, $this->Student->getId());

        // 获取课程及学生课程信息
        $Course = $Word->getCourse();
        $StudentCourse = new StudentCourse($this->Student, $Course);
        
        // 传入课程及学生课程对象（其实传入学生课程就可以了，然后在学生课程中去定义get方法来获取学生或是课程信息。）
        $this->assign("Course", $Course);               // 获取当前学习进度
        $this->assign("StudentCourse", $StudentCourse); // 用于获取今日新学与复习的单词数

        $this->assign('Test', new Test);
        $this->assign("Word", $Word->getJsonData($this->Student));
        $this->assign('url', U("Study/getNextReviewWordOfNewWordsAjax"));
        $this->display("index");
    }


    /**
     * 获取 全部词汇 学习时，下一个学习的单词
     * @param    integer                  $wordId 单词id
     * @return   ajax                           
     * @author 梦云智 http://www.mengyunzhi.com
     * @DateTime 2016-10-26T16:47:34+0800
     */
    public function getNextReviewWordOfNewWordsAjaxAction($wordId = 0, $type = 'know', $testId = 0)
    {
        $data = [];
        try {
            //赋值返回
            $data["status"] = "SUCCESS";

            // 取需要进行二次学习的单词
            $StudentWordStudyListModel = new StudentWordStudyListModel;
            $Word = new Word($wordId);
            if (0 !== $Word->getId()) {
                $StudentWordStudyListModel->computeAndSetNextAppearTime($Word, $this->Student, $type);
            }

            // 获取复习列表中当前需要学习的单词
            $nowWord = $StudentWordStudyListModel->getNowStudyWord($this->Student);

            // 学习列表中当前不需要进行单词学习，则取当前课程的下一单词
            if (0 === $nowWord->getId()) {
                // 取出下一个要学习的单词
                $nowWord = NewWord::getNextNewWord($this->Student);
            }   

            unset($StudentWordStudyListModel);
            $data["data"] = $nowWord->getJsonData();
        } catch (\Exception $e) {
            $data["status"] = "ERROR";
            $data['message'] = $e->getMessage();
        }

        $this->ajaxReturn($data);
        return;
    }
}