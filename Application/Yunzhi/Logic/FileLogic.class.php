<?php
namespace Yunzhi\Logic;

/**
 * 对文件进行操作的类
 */
class FileLogic
{
    protected $error;

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * 删除相对于Public路径的文件
     * @param  string $fileName 相对于public的路径文件名
     * @return bool
     */
    public function unlink($fileName)
    {
         //拼接入口路径
        $root = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/';

        //拼接文件绝对路径
        $fileName = $root . $fileName;

        try
        {
            return unlink($fileName);
        }
        catch(\Exception $e)
        {
            $this->setError("unlink $fileName error: " . $e->getMessage());
            return false;
        }
    }
}