<?php
namespace Admin\Model\Data;

use Admin\Model\Dir;
use Admin\Model\File;

class BaseModel
{
    private $path;
    private $totalCount;    // 数据条数
    private $error = "";
    protected $Dir;
    protected $File;

    public function __construct()
    {

    }

    public function getError()
    {
        return $this->error;
    }

    public function setPath($path)
    {
        $this->path = $path;
        $this->Dir = new Dir($path);
    }

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function getLists()
    {
        $lists = $this->Dir->getLists();
        $this->totalCount = $this->Dir->getTotalCount();
        return $lists;
    }
}