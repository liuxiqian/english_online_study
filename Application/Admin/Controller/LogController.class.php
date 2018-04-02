<?php
namespace Admin\Controller;

use Yunzhi\Logic\MysqlRebackLogic;
use Admin\Model\Data\BaseModel;     // 共用数据管理基础模型
use Admin\Model\File;
/**
 * 数据管理
 */
class LogController extends AdminController
{
    private $appPath;
    private $path;

    public function __construct($config = array()) {
        $this->appPath = dirname(THINK_PATH) . '/Runtime';
        $this->path = $this->appPath . '/File/Log';
        parent::__construct();
    }


    public function indexAction()
    {
        $M = new BaseModel;
        $M->setPath($this->path);
        $this->assign("M", $M);   
        $this->display();
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