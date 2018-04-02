<?php
namespace Admin\Controller;

use Klass\Logic\KlassLogic;                     //班级
use KlassUserView\Logic\KlassUserViewLogic;     //班级用户视图
use Admin\Model\Klass\indexModel;               //班级管理index小模型
use Student\Logic\StudentLogic;                 //学生
use KlassCourseView\Logic\KlassCourseViewLogic; //班课课程关联视图
use KlassCourse\Logic\KlassCourseLogic;         //班级课程关联表
use Course\Logic\CourseLogic;                   //课程
use Admin\Model\Klass\addCourseModel;           //新增课程小模型
use Admin\Model\Klass\BaseModel;
use Home\Model\Teacher;     
use Home\Model\Article;     
use Home\Model\Klass;      
use ArticleKlass\Model\ArticleKlassModel;            // 阅读闯关、班级         

/* 
后台
班级管理
*/
class KlassController extends AdminController
{
    public function indexAction()
    {
        try
        {   
            //获取当前登录用户的信息
            $user = $this->getUser();

            //对当前登录用户进行身份判断
            $indexModel = new indexModel();
            $indexModel->setUserId($user['id']);
            if($indexModel->isSon() === 1)          //判断是否位子区域
            {
                if($indexModel->isAdmin() === 1)    //判断是否为管理员
                {
                    //当前用户是区域管理员
                    $indexModel->setTeachers($indexModel->getCurrentDepartmentTeachers());
                    $datas = $indexModel->getDepartmentLists();
                }
                else
                {
                    //当前用户是教务员
                    $indexModel->setTeachers(array("0" => array("id" => $user['id'],"name" => $user['name'])));
                    $datas = $indexModel->getListsByUserId($user['id']);
                }
            }
            else
            {
                // 当前用户是系统管理员
                $indexModel->setTeachers($indexModel->getAllTeachers());
                $datas = $indexModel->getLists();
            }


            $this->assign("datas", $datas);
            $this->assign("M",$indexModel);
            $this->display();
        }
        catch(\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }

    public function addAction()
    {
        //获取当前登录用户的信息
        $user = $this->getUser();
        $currentTeacher = new Teacher($user['id']);

        //获取班级ID
        $klassId = I('get.id');

        //取班级信息getListById()
        $KlassL = new klassLogic();
        $data = $KlassL->getListById($klassId);

        //传给前台
        $this -> assign('data',$data);
        $this->assign('currentTeacher', $currentTeacher);

        //显示display('add')
        $this -> display('add');
    }

    public function saveAction()
    {
        try
        {
            $KlassL = new klassLogic();
            if ($KlassL->saveList(I('post.')) === false)
            {
                $this->error("保存错误:".$KlassL->getError(),U("index?id=",I('get.')));
            }
            else
            {   
                $this->success("操作成功",U("index?id=",I('get.')));
            }
        }
        catch(\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }

    public function viewStudentAction()
    {
        try
        {
            //取对应班级id
            $klassId = I('get.klass_id');

            //取对应班级的学生
            $StudentL = new StudentLogic();
            $map=array("klass_id"=>$klassId);
            $StudentL->setMaps($map);
            $datas=$StudentL->getLists();
            
            $M = new BaseModel();
            $this->assign('datas',$datas);
            $this->assign('klass_id',$klassId);
            $this->assign('M',$M);
            $this->display();
        }
        catch(\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }

    public function assignCourseAction()
    {
        try
        {
            //取班级id
            $klassId = I('get.klass_id');

            //取当前班级的课程
            $KlassCourseViewL = new KlassCourseViewLogic();
            $datas=$KlassCourseViewL->setMaps(array("klass_id" => $klassId))->getLists();

            //向V层赋值
            $M = new BaseModel();
            $this->assign('M',$M);
            $this->assign('klass_id',$klassId);
            $this->assign('datas',$datas);
            $this->display();
        }
        catch(\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }

    public function deleteCourseAction()
    {
        try
        {
            //取当前班级所删课程id
            $courseId=I('get.course_id');
            $klassId=I('get.klass_id');

            //按条件删除
            $map=array("klass_id" => $klassId,"course_id" => $courseId);
            $KlassCourseL = new KlassCourseLogic();
            if($KlassCourseL->where($map)->delete() ===false)
            {
                $this->error("删除失败：" . $KlassCourseL->getError(), U('assignCourse?id=', I('get.')));
                return;
            }
            else
            {
                $this->success('操作成功', U('assignCourse?id=', I('get.')));
                return;
            }
        }
        catch(\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }

    public function addCourseAction()
    {
        try
        {
             //取班级id
            $klassId=I('get.klass_id');

            //取课程表中数据
            $CourseL = new CourseLogic();
            $datas=$CourseL->getAllLists();
            foreach ($datas as $key => $value) {
                $allCourseIds[]=$value['id'];
            }

            //取当前班级已有的课程
            $KlassCourseL = new KlassCourseLogic();
            $klasscourses=$KlassCourseL->setMaps(array('klass_id' =>$klassId))->getAllLists();

            foreach ($klasscourses as $key => $value) {
                $currentCourseIds[] = $value['course_id'];

            }
            $currentCourseIds[]=0;//当前班级没有课程时，令$currentCourseIds中有值，可用array_diff()函数

            //取出当前班级没有的课程
            $datas = array_diff($allCourseIds,$currentCourseIds);

            $addCourseModel = new addCourseModel();
            $this->assign('M',$addCourseModel);
            $this->assign('datas',$datas);
            $this->assign('klass_id',$klassId);
            $this->display();
        }
        catch(\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }

    public function saveCourseAction()
    {
        try
        {
            //取表单课程信息
            $courses = I('post.');

            //存班级课程关联数据
            $datas['klass_id'] = $courses['klass_id'];
            $KlassCourseL = new KlassCourseLogic();
            foreach ($courses['data'] as $key => $value) {
                $datas['course_id'] = $value;
                if ($KlassCourseL->saveList($datas) === false)
                {
                    $this->error("保存错误:".$KlassCourseL->getError(),U("assignCourse?id=",I('get.')));
                    return false;
                }
            }
            $this->success("操作成功",U("assignCourse?id=",I('get.')));
            return true;
        }

        catch(\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }

    public function deleteAction()
    {
        //取班级id
        $klassId = I('get.id');
        $KlassL = new KlassLogic();
        if($KlassL->deleteList($klassId) === false)
        {
            $this->error("删除失败：".$KlassL->getError(), U('index?id=',I('get.')));
            return;
        }
        else
        {
            $this->success("操作成功", U('index?id=', I('get.')));
            return;
        }

    }

    /**
     * 阅读闯关列表
     * @return array Article
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function articleIndexAction()
    {
        $klassId = (int)I('get.klass_id');
        $Klass = new Klass($klassId);
        if (0 == $Klass->getId())
        {
            $this->error('传入的班级信息有误');
            return;
        }

        $articles = Article::getArticles($Klass);
        $this->assign('Klass', $Klass);
        $this->assign('articles', $articles);
        $this->display();
    }


    public function articleSaveAjaxAction()
    {
        // 如果存在，则删除，如果不存在，则添加
        $map = array();
        $map['klass_id'] = I('get.klass_id');
        $map['article_id'] = I('get.article_id');
        $ArticleKlassM = new ArticleKlassModel();
        $list = $ArticleKlassM->where($map)->find();
        if (null === $list)
        {
            $ArticleKlassM->saveList($map);
        } else {
            $ArticleKlassM->deleteListById($list['id']);
        }
        $this->ajaxReturn(array());
    }
}