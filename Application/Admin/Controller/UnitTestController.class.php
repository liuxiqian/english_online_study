<?php
namespace Admin\Controller;


use Think\Controller;
use Yunzhi\Logic\PHPExcelLogic;     //phpexcel
use Yunzhi\Logic\ZipLogic;          //zip打包
use PhpOffice\PhpWord\PhpWord;      //phpword
use Yunzhi\Logic\FileLogic;         //文件操作
// use Home\Model\Schedule\BaseModel;

class UnitTestController extends Controller {
    
    public function __construct()
    {
        if (APP_DEBUG === false)
        {
            die("Error, not debug mode");
        }
        parent::__construct();
    }

    public function indexAction()
    {
        $this->display();
    }

    /**
     * 读取excel，并将excel数据作为数组返回示例
     * 
     */
    public function readExcelAction()
    {
        //读取execl文件，并将结果做为数组返回
        $filePath = "/Applications/XAMPP/htdocs/paper_approving/Application/Test/yunzhi.xlsx";
        $ReadL = new PHPExcelLogic;
        if (!$data = $ReadL->ReadFile($filePath))
        {
            dump($ReadL->getError());
        }
        else
        {
            dump($data);
        }
    }

    /**
     * 
     * @return [type] [description]
     */
    public function writeExcelAction()
    {
        try
        {
            $data = array(
                array('name' => 'NAME', 'mail' => 'EMAIL', 'age' => 'age'),
                array('name' => 'A', 'mail' => 'a@gmail.com', 'age' => 43),
                array('name' => 'C', 'mail' => 'c@gmail.com', 'age' => 24),
                array('name' => 'B', 'mail' => 'b@gmail.com', 'age' => 35),
                array('name' => 'G', 'mail' => 'f@gmail.com', 'age' => 22),
                array('name' => 'F', 'mail' => 'd@gmail.com', 'age' => 52),
                array('name' => 'D', 'mail' => 'g@gmail.com', 'age' => 32),
                array('name' => 'E', 'mail' => 'e@gmail.com', 'age' => 34),
                array('name' => 'K', 'mail' => 'j@gmail.com', 'age' => 18),
                array('name' => 'L', 'mail' => 'h@gmail.com', 'age' => 25),
                array('name' => 'H', 'mail' => 'i@gmail.com', 'age' => 28),
                array('name' => 'J', 'mail' => 'j@gmail.com', 'age' => 53),
                array('name' => 'I', 'mail' => 'l@gmail.com', 'age' => 26),
            );
            // 将数组中的值写入EXCEL，供用户下载
            $ReadL = new PHPExcelLogic;

            //添加数据并生成excel文件
            $ReadL->arrayToExcel($data)->save("download/test");
        }
        catch(\Exception $e)
        {
            echo $e->getMessage();
        }
        
    }



    public function ueditorAction()
    {
        $this->display();
    }

    public function ueditorSaveAction()
    {
        dump($_POST);
    }
    public function zipAction(){
        //zip打包文件测试
        $ZipL = new ZipLogic();
        $ZipL->zip("/Applications/XAMPP/xamppfiles/htdocs/paper_approving/Public/uploads/image",
            "/Applications/XAMPP/xamppfiles/htdocs/paper_approving/Public/uploads/image.zip"
            );
    }

    public function phpWordAction()
    {
        // 
        $phpWord = new PhpWord();
        dump($phpWord);
    }

    public function uploadifyAction()
    {
        dump($_POST);
        $this->display();
    }

    /**
     * 删除相对于public 下的文件 文件
     * @return  
     */
    public function unlinkAction()
    {
        $file = "download/test.txt";
        $FileL = new FileLogic();
        if ($FileL->unlink($file) === false)
        {
            echo "error";
        }
        else
        {
            echo "done";
        }
    }

    public function testAction()
    {
        //$L = new \DepartmentPost\Logic\DepartmentPostLogic();
        // $M = new \Menu\Logic\MenuLogic();
        // $P = new \Post\Logic\PostLogic();
       // $D = new \Department\Logic\DepartmentLogic();
        //$U = new \User\Logic\UserLogic();
        //$K = new \Klass\Logic\KlassLogic();
        // $StudentL = new \Student\Logic\StudentLogic();
        //$CardBatchL = new \CardBatch\Logic\CardBatchLogic();
        // $LoginL = new \Login\Logic\LoginLogic();
        // $W = new \WordNature\Logic\WordNatureLogic();
        // $map['name'] = "7";
       // dump($L->where($map)->prepareDelete());
        // dump($M->where($map)->prepareDelete());
        // dump($P->where($map)->prepareDelete());
        //dump($D->where($map)->prepareDelete());
        //dump($U->where($map)->prepareDelete());
        //dump($K->where($map)->prepareDelete());
        // dump($StudentL->where($map)->prepareDelete());
       //dump($CardBatchL->where($map)->prepareDelete());
       // dump($LoginL->where($map)->prepareDelete());
        // dump($W->where($map)->prepareDelete());
       // dump($L->getError());
        // dump($M->getError());
        // dump($P->getError());
       // dump($D->getError());
       // dump($U->getError());
        //dump($K->getError());
        // dump($StudentL->getError());
        //dump($CardBatchL->getError());
        //dump($LoginL->getError());
        // dump($W->getError());
        //dump($L->where($map)->delete());
        // dump($M->where($map)->delete());
        // dump($P->where($map)->delete());
       // dump($D->where($map)->delete());
        //dump($U->where($map)->delete());
        //dump($K->where($map)->delete());
        // dump($StudentL->where($map)->delete());
         //dump($CardBatchL->where($map)->delete());
         //dump($LoginL->where($map)->delete());
         // dump($W->where($map)->delete());

        $M = new \Admin\Model\Schedule\BaseModel();
        dump($M->getListsByUserId(6));
    }

}
