<?php
namespace Admin\Controller;
use Home\Model\Cache;       // 缓存

class CacheController extends AdminController
{
    public function indexAction()
    {
        $result = array();
        $status = -1;
        if (I('get.action') == 'clear')
        {
            // 清理redis缓存
            Cache::clean();

            // 清理文件缓存.TODO:更改原文件缓存为redis缓存
            $TempPath = dirname(THINK_PATH) . '/Runtime/Temp';
            exec('rm -rf ' . $TempPath . ' 2>&1', $result, $status);
        }

        // 传入执行的状态及结果
        $this->assign('status', $status);
        $this->assign('result', $result);
        return $this->display();
    }
}