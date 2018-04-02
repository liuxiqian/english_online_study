<?php
namespace Admin\Model;

class Log
{
    private $path;          // 文件夹位置
    private $logRecords;    // 记录日志的操作数组
    private $user;          // 当前用户信息
    public function __construct($logRecords, $path, $user)
    {
        if (!is_array($logRecords))
        {
            E("传入的变量类型错误");
        }
        $this->logRecords = $logRecords;
        $this->path = $path;
        $this->user = $user;

        // 自动创建日志目录
        if (!is_dir(dirname($path))) {
            if (!mkdir(dirname($path), 0755, true))
            {
                E("创建文件夹失败，请手动创建文件夹" . dirname($path));
            }
        }  

        if (!is_dir($path)) {
            if (!mkdir($path, 0755, true))
            {
                E("创建文件夹失败，请手动创建文件夹$path");
            }
        }  
    }

    public function write()
    {
        foreach ($this->logRecords as $logRecord)
        {
            if ($this->_getIsCurrent($logRecord['c'], $logRecord['a']))
            {
                $log = array();
                $log[] = date("H:i:s");
                $log[] = $this->user['username'];
                $log[] = $this->user['name'];
                $log[] = I('server.REMOTE_ADDR');
                $log[] = I('server.REQUEST_URI');
                $logStr = implode($log, ",") . "\r\n";
                $fileName = date("Y-m-d") . '.log';
                $pathname = $this->path . '/' . $fileName;
                if (!$handle = fopen($pathname, 'a+'))
                {
                    E("日志文件未写入，请检查权限");
                }
                fwrite($handle, $logStr);
                fclose($handle);
            }
            return;
        }
    }

    private function _getIsCurrent($c, $a)
    {
        if (!strcasecmp(CONTROLLER_NAME, $c) && !strcasecmp(ACTION_NAME, $a))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}