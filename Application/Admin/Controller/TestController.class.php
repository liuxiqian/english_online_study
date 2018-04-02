<?php
namespace Admin\Controller;

use Admin\Model\Test\BaseModel;
use Yunzhi\Logic\PHPExcelLogic;
use Admin\Model\File;
/**
* 
后台
测试查询
*/
class TestController extends AdminController
{
    public function __construct(){
        parent::__construct();

        $this->appPath = dirname(THINK_PATH) . '/Public';
        $this->path = $this->appPath . '/download/test';

        $user = $this->getUser();
        $this->M = new BaseModel();
        $this->M->setUserId($user['id']);
    }

    public function indexAction()
    {
        $this->assign("M",$this->M);
        $this->display();
    }

    /**
     * 生成excel
     * @author xulinjie
     */
    public function excelAjaxAction()
    {
        $res['status'] = 'ERROR';
        try
        {
            //生成excel数组
            $data = array(
                array('klass' => '班级', 'name' => '姓名', 'testCount' => '测试次数', 'learnBeforeTestGrade' => '学前（%）', 'learnAfterTestGrade' => '学后（%）', 'newWordsCount' => '新学个数', 'oldWordsCount' => '复习个数', 'courseTitle' => '所学课程'));

            $lists = $this->M->getStudents();

            foreach ($lists as $key => $value) {
                $data[$key+1]['klass'] = $value['klass__name'];
                $data[$key+1]['name'] = $value['name'];
                $data[$key+1]['testCount'] = $this->M->getTestCountByStudentId($value['id']);
                $data[$key+1]['learnBeforeTestGrade'] = (string)$this->M->getLearnBeforeTestGradeByStudentId($value['id']);
                $data[$key+1]['learnAfterTestGrade'] = (string)$this->M->getLearnAfterTestGradeByTimeStudentId($value['id']);
                $data[$key+1]['newWordsCount'] = $this->M->getNewWordsByStudentId($value['id']);
                $data[$key+1]['oldWordsCount'] = $this->M->getOldWordsByStudentId($value['id']);

                $courseTitleLists = $this->M->getTestCourseTitleByStudentId($value['id']);
                foreach ($courseTitleLists as $value) {
                    $courseTitle .= $value . '/';
                }
                $data[$key+1]['courseTitle'] = $courseTitle;
            }
            // dump($data);
            // die();
            //文件夹不存在，新建文件夹
            if(!file_exists($this->path)){
                mkdir($this->path);
            }

            //清空文件夹里面的文件
            $url = 'download/test/test';
            if (file_exists($url)) {
                unlink($url);
            }

            // 将数组中的值写入EXCEL，供用户下载
            $ReadL = new PHPExcelLogic();

            //添加数据并生成excel文件
            $ReadL->arrayToExcel($data)->save("$url");

            $res['status'] = 'SUCCESS';
            $this->ajaxReturn($res);
            return;
        }
        catch(\Exception $e)
        {
            $res['message'] = $e->getMessage();
            $this->ajaxReturn($res);
            return;
        }
    }

    /**
     * 导出excel
     * @author xulinjie
     */
    public function downloadAction()
    {
        $jumpUrl = U("index", I('get.'));
        $pathname = $this->path . '/' . 'test.xls';
        // echo $pathname;
        // die();
        try
        {
            $File = new File($pathname);
            if ($File->download() === false)
            {
                $this->error("下载错误：" . $File->getError(), $jumpUrl);
                return;
            }
        }
        catch(\Exception $e)
        {
            $this->error("下载错误：" . $File->getError(), $jumpUrl);
            return;
        }
        $this->success("下载成功:", $jumpUrl);
    }
}