<?php
/**
 * 单词管理
 */
namespace Admin\Controller;

use Admin\Model\Word\addModel;
use Admin\Model\Word\indexModel;
use Course\Model\CourseModel;
use Word\Model\WordModel;
use Word\Logic\WordLogic;                       //单词
use WordExplain\Logic\WordExplainLogic;         //单词词性信息
use WordWordNature\Logic\WordWordNatureLogic;   //单词扩展信息
use Course\Logic\CourseLogic;                   //课程信息
use Attachment\Logic\AttachmentLogic;               //附件
use Home\Model\Word;                            // 单词
use think\Upload;                               // 文件上传
use Home\Model\Course;                          // 课程

class WordController extends AdminController
{
    public function indexAction()
    {  
        $M = new indexModel();

        //获取课程信息
        $courseId = (int)I('get.courseid');
        $WordL = new WordLogic();
        if ($courseId !== 0)
        {
            $map = array();
            $map['course_id'] = (int)$courseId;
            $WordL->addMaps($map);
        }

        //获取单词信息
        $lists = $WordL->getLists();

        $this->assign("M", $M);
        $this->assign("lists", $lists);
        $this->display();
    }

    /**
     * 删除单词信息
     * 1.删除本单词信息 word
     * 2.删除本单词扩展信息 word_extend
     * @return  
     * panjie
     * 2016.03
     */
    public function deleteAction()
    {
        $id = (int)I('get.id');
        //dump($id);
        //删除单词信息
        $WordL = new WordLogic();
        if ($WordL->deleteList($id) === false)
        {
            $this->error("系统错误-删除单词基本信息出错：" . $WordL->getError());
        }
        
        $this->success("操作成功", U('index?id=', I('get.')));
    }

    /**
     * 保存单词。
     * 1.先取当前课程，查看是否存在，不存在，报错。
     * 2.存基本信息至word表
     * 3.存扩展信息至word_extend表
     * @return  
     * panjie
     * 2016.03
     */
    public function saveAction()
    {
        $data = I('post.');

        //查找是否存在当前课程信息
        $CourseL = new CourseLogic();
        if ($CourseL->getListById($data['course_id']) === false)
        {
            $this->error("传入的课程信息有误", U("index", I('get.')));
        }

        //保存基本信息
        $WordL = new WordLogic();
        $data['id'] = $WordL->saveList($data);
        if ($data['id'] === false)
        {
            $this->error("数据保存过程出错，错误信息: " . $WordL->getError(), U("index", I('get.')));
        }

        //保存词性信息
        $WordExplainL = new WordExplainLogic();
        if ($WordExplainL->saveLists($data) === false)
        {
            $this->error("单词词性保存过程出错，错误信息: " . $WordExplainL->getError(), U("index", I('get.')));
        }
        

        //保存扩展信息
        $WordWordNatureL = new WordWordNatureLogic;
        if ($WordWordNatureL->saveLists($data['id'], $data['word_nature_id'], $data['word_word_nature_title'], $data['word_word_nature_explain']) === false)
        {
            $this->error("单词扩展信息保存过程出错，错误信息: " . $WordWordNatureL->getError(), U("index", I('get.')));
        }

        // 如果是由课程管中的跳转过来的，那么，我们再调回课程
        $from = I('get.from');
        if ($from == 'course') {
            $this->success('操作成功', U('Course/unFetchedAudio?from=&courseid=&id=' . I('get.courseid'), I('get.')));
            return;
        }

        //如果为课程添加单词界面，则跳转至继续添加
        $courseId = I('get.course_id');
        if ($courseId !== "")
        {
            $this->success("操作成功", U('add', I('get.')));
        }
        //如果为编辑单词界面，则跳转至index
        else
        {
            $this->success("操作成功", U('index?id=', I('get.')));
        }
    }

    public function addAction()
    {           
        //定制错误跳转URL
        $errorUrl =  U('index?id=', I('get.'));

        //取单词信息，如果未传入单词ID，则取课程信息
        $WordL = new WordLogic;
        $id = I('get.id');
        $Word = new Word($id);
        if ($id !== "")
        {
            //取单词信息
            $word = $WordL->getListById(I('get.id'));
            if ($word === false)
            {
                $this->error("取出单词信息错误:" . $WordL->getError(), $errorUrl);
            }

            if ($word === null)
            {
                $this->error("您所要编辑的单词记录不存，或已删除", $errorUrl);
            }

            $courseId = $word['course_id'];
        }
        else
        {
            $id = null;
        }
        
        //如果存在课程ID，则继续，如果不存在，则取传入课程ID信息
        $courseId = $courseId === null ? (int)I('get.courseid') : $courseId;
        $CourseL = new CourseLogic();

        //取课程信息
        $course = $CourseL->getListById($courseId);
        if ($course === false)
        {
            $this->error("未获取到课程信息，或您要操作的课程已删除", $errorUrl);
        }
        
        //实例化小M，同时获取课程信息
        $M = new addModel();
        $M->id = $id;
        $M->courseId = $courseId;
        $M->getCourse();

        //传入V层
        $this->assign("Word", $Word);
        $this->assign("M", $M);
        $this->assign("data", $word);
        $this->display('add');
    }

    public function editAction()
    {
        return $this->addAction();
    }

    /**
     * 整理单词顺序
     * 添加完毕新单词后，需要重新整理。
     * @return  
     * panjie
     */
    public function reOrderAction()
    {
        $allCourses = Course::getAllCourses();
        $this->assign('allCourses', $allCourses);
        
        $courseId = I('get.courseId');
        $Course = new Course($courseId);

        if ($Course->getId() != 0)
        {
            $WordM = new WordModel;
            $words = $WordM->field('id')->where('course_id='. $Course->getId())->order(array('order'=>'asc','id'=>'asc'))->select();
            $count = count($words);
            $word = array();
            $perId = 0;


            // 重新整理
            for ($i = 0; $i < $count; $i++)
            {
                if ($i < $count - 1)
                {
                    if (isset($words[$i+1]['id']))
                    {
                        $nextId = (int)$words[$i+1]['id'];
                    }
                }
                else
                {
                    $nextId = 0;
                }

                $word['id'] = $words[$i]['id'];
                $word['pre_id'] = $perId;
                $word['next_id'] = $nextId;
                $word['index'] = $i+1;
                $WordM->saveList($word);

                $perId = $word['id'];
            }
            var_dump('done');
        }

        $this->display();
    }

    /**
     * 抓取单词的基本信息
     * @return json 
     */
    public function queryWordAjaxAction()
    {
        $word = I('get.word');
        $url = "http://fanyi.youdao.com/openapi.do?keyfrom=sfdfsdfsd&key=1559675985&type=data&doctype=json&version=1.1&q=" . $word;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);                          //设置URL
        curl_setopt($ch,CURLOPT_TIMEOUT, 60);                       //设置过期时间
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);               //设置传输方式？
        $temp = curl_exec($ch);   
        echo $temp;
    }

    /**
     * 上传文件
     * @return json data
     * panjie
     * 2016.04
     */
    public function uploadAjaxAction()
    {
        $AttachmentL = new AttachmentLogic();
        $action = "uploadimage";
        $this->ajaxReturn($AttachmentL->upload($action));
    }

    /**
     * 上传音频文件
     * @param string $type 类型 uk:英音,us:美音
     * @param string $title 单词的标题
     * @return json data 
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function uploadAudioAjaxAction()
    {
        $type = I('get.type');      
        $title = I('get.title');

        $title = Word::reMakeTitle($title);
        
        // 定制上传配置信息
        $config = array(
            'mimes'         =>  array('audio/*', 'audio/mpeg'), //允许上传的文件MiMe类型
            'maxSize'       =>  1024000, //上传的文件大小限制 (0-不做限制)
            'exts'          =>  array('mp3'), //允许上传的文件后缀
            'autoSub'       =>  false, //自动子目录保存文件
            'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath'      =>  './audio/', //保存根路径
            'savePath'      =>  $type . '/', //保存路径
            'saveName'      =>  $title, //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
            'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
            'replace'       =>  true, //存在同名是否覆盖
            'hash'          =>  false, //是否生成hash编码
            'callback'      =>  false, //检测文件是否存在回调，如果存在返回文件信息数组
            );
        
        // 实例化上传类
        $Upload = new Upload($config);   
        if ($Upload->uploadOne($_FILES['yunzhifile']))
        {
            $result['state'] = 'SUCCESS';
        } else {
            $result['state'] = 'ERROR';
            $result['message'] = '上传失败，请检查上传文件夹权限或是否在其实附件上传中，上传了相同的文件';
        }

        // 返回json数据 
        $this->ajaxReturn($result);
    }
}