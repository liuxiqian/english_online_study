<?php
namespace Admin\Model;

/**
 * 文件夹
 */
class Dir extends \DirectoryIterator
{
    private $p;                     // 当前页
    private $pageSize;              // 每页大小
    private $totalCount;            // 总条数

    public function __construct($path)
    {
        $this->p = (int)I('get.p') > 0 ? (int)I('get.p') : 1;
        $this->pageSize = (int)I('get.pagesize') > 0 ? (int)I('get.pagesize') : C("YUNZHI_PAGE_SIZE");
        parent::__construct($path);
    }

    /**
     * 获取列表
     * @return array File
     */
    public function getLists()
    {
        // 求出文件序列
        $sequence = $this->getFileSequence();
        $length = count($sequence);

        $result = array();
        $position = ($this->p - 1) * $this->pageSize;   //本页开始
        for($i = $position; $i < $position + $this->pageSize; $i++)
        {
            if ($i === $length)
            {
                break;
            }
            $this->seek($sequence[$i]);
            $result[] = new File($this->getPathname());
        }
        return $result;
    }

    /**
     * 获取目录下的文件总数
     * @return int 
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * 求文件序列 主要目的是把所有的文件筛选出来，去除文件夹，LINK之类的文件。
     * 再然后将文件在当前文件夹中的POSTION存在序列当中。
     * 最后将序列倒转，实现由创建时间由近及远排序的目的
     * @return array 
     */
    public function getFileSequence()
    {
        static $result = array();
        if (empty($result))
        {
             foreach ($this as $key => $fileInfo)
            {
                if ($fileInfo->isFile())
                {
                    $result[] = $key;
                }
            } 
            $this->totalCount = count($result);
            $result = array_reverse($result);
        }
        return $result;
    }
}