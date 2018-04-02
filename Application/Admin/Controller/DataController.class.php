<?php
namespace Admin\Controller;

use Yunzhi\Logic\MysqlRebackLogic;
use Data\Logic\DataLogic;
use Admin\Model\Data\BaseModel;     // 基础模型
use Admin\Model\File;
/**
 * 数据管理
 */
class DataController extends AdminController
{
    private $appPath;
    private $path;


    public function __construct($config = array()) {
        $this->appPath = dirname(THINK_PATH) . '/Runtime';
        $this->path = $this->appPath . '/File/Sql';
        parent::__construct();
    }

    public function backUpAction()
    {
        try
        {
            $MySQLRebackL = new MySQLRebackLogic($this->path);
            $MySQLRebackL->setDBName(C("DB_NAME"));
            $MySQLRebackL->backup();
            $this->success("备份成功", U('index', I('get.')));
        }
        catch(\Think\Exception $e)
        {
            $this->error("备份失败：" . $e->getMessage(), U('index', I('get.')));
            return;
        }

    }


    public function indexAction()
    {
        $M = new BaseModel;
        $M->setPath($this->path);
        $this->assign("M", $M);   
        $this->display();
    }

    public function deleteAction()
    {
        $jumpUrl = U("index?filename=", I('get.'));
        $filename = I('get.filename');
        $pathname = $this->path . '/' . $filename;
        try
        {
            $File = new File($pathname);
            if ($File->delete() === false)
            {
                $this->error("删除错误：" . $File->getError(), $jumpUrl);
                return;
            }
        }
        catch(\Exception $e)
        {
            $this->error("删除错误：" . $File->getError(), $jumpUrl);
            return;
        }
        $this->success("删除成功:", $jumpUrl);
    }

    public function downloadAction()
    {
        $jumpUrl = U("index?filename=", I('get.'));
        $filename = I('get.filename');
        $pathname = $this->path . '/' . $filename;
        try
        {
            $File = new File($pathname);
            if ($File->download() === false)
            {
                $this->error("删除错误：" . $File->getError(), $jumpUrl);
                return;
            }
        }
        catch(\Exception $e)
        {
            $this->error("删除错误：" . $File->getError(), $jumpUrl);
            return;
        }
        $this->success("删除成功:", $jumpUrl);
    }
}