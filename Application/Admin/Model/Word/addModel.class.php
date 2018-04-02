<?php
namespace Admin\Model\Word;

use Word\Logic\WordLogic;                       //单词
use Course\Logic\CourseLogic;                   //课程
use WordNature\Logic\WordNatureLogic;           //单词扩展属性
use WordWordNature\Logic\WordWordNatureLogic;   //单词扩展信息
use WordExplain\Logic\WordExplainLogic;         //单词词性
use Attachment\Logic\AttachmentLogic;             //附件

class addModel
{
    protected $wordNatureLists = null;      //扩展属性列表
    public $courseId = null;                //课程ID
    public $id = null;                      //单词ID

    public function __construct()
    {
        $this->WordL = new WordLogic();
        $this->CourseL = new CourseLogic();
        $this->WordExplainL = new WordExplainLogic();
    }

    /**
     * 获取附件URL信息
     * @return string
     */
    public function getAttachmentUrl()
    {
        try
        {
            $AttachmentL = new AttachmentLogic();
            $word = $this->getList();
            return $AttachmentL->getUrlById($word['attachment_id']);
        }
        catch(\Think\Exception $e)
        {
            echo "getAttachmentUrl error" . $e->getMessage();
            return;
        }
        catch(\Exception $e)
        {
            echo "getAttachmentUrl error" . $e->getMessage();
            return;
        }
        
    }

    public function getCourse()
    {
        $this->CourseL = new CourseLogic();
        $this->course = $this->CourseL->getListById($this->courseId);
    }
    public function getJsonList()
    {
        $list = $this->getList();
        if (count($list) === 0)
        {
            $list = new \stdClass();
        }
        return $list;
    }

    public function getList()
    {
        try
        {
            static $list = false;
            if ($list !== false)
            {
                return $list;
            }

            $WordL = new WordLogic();
            if (($list = $WordL->getListById($this->id)) === false)
            {
                 E("wordLogic:getListById error" . $WordL->getError());
            }
            if ($list === null)
            {
                return array();
            }
            return $list;
        }
        catch(\Think\Exception $e)
        {
            echo "getListById error:" . $e->getMessage();
            return false;
        }
    }

    /**
     * 通过单词ID获取释义信息
     * @param  int $id 
     * @return lists     
     * panjie
     * 2016.04
     */
    public function getExplains()
    {
        try {
            if ($this->id === null)
            {
                return array();
            }

            $map = array();
            $map['word_id'] = $this->id;
            $lists = $this->WordExplainL->where($map)->select();
            $result = array();
            foreach($lists as $list)
            {
                $result[] = $list['value'];
            }

            return $result;

        } catch (\Think\Exception $e) {
            echo "WordExplainLogic error:" . $e->getMessage();
            return false;
        }
    }

    /**
     * 获取单词扩展属性列表
     * @return lists 
     * panjie 
     * 2016.04.11
     */
    public function getWordNatureLists()
    {
        if ($this->wordNatureLists === null)
        {
            try
            {
                $WordNatureL = new WordNatureLogic;
                $this->wordNatureLists = $WordNatureL->getAllLists();
            }
            catch(\Think\Exception $e)
            {
                echo "get word nature lists error:" . $e->getMessage();
                return false;
            }
        }
        return $this->wordNatureLists;
    }

    /**
     * 通过单词ID获取单词的扩展信息 
     * @param  int $id 
     * @return lists     
     * panjie
     * 2016.04.11
     */
    public function getWordWordNatureLists()
    {
        $map = array();
        $map['word_id'] = $this->id;
        try
        {
            $WordWordNatureL = new WordWordNatureLogic;
            return $WordWordNatureL->setMaps($map)->setBackFields(array('id', "title", 'explain', "word_nature_id"))->getAllLists();
        }
        catch(\Think\Exception $e)
        {
            echo "WordWordNatureLogic error:" . $e->getMessage();
            return false;
        }
    }

    /**
     * 获取按我们设定好，排序的单词列表
     * @return lists
     * panjie
     * 2016.04
     */
    public function getCrouseLists()
    {
        try
        {
            //引用静态变量，提升查询效率
            static $returns = false;
            if ($returns !== false)
            {
                return $returns;
            }

            $WordL = new WordLogic();
            $backFields = array("id", "order", "title");
            $map = array("course_id"=>$this->courseId);

            $returns = $WordL->setBackFields($backFields)->setMaps($map)->getAllLists();

            //遍历添加字段
            $list = $this->getList();
            if (empty($list))
            {
                $index = count($returns);
                $returns[$index]['title'] = "最后";
                $returns[$index]['order'] = $returns[$index-1]['order'] + 1;
            }
            else
            {
                foreach($returns as $key => $word)
                {
                    if ($word['id'] == $list['id'] )
                    {
                        $index = $key;
                    }
                }
            }
            $returns[$index]['selected'] = true;
            return $returns;
        }
        catch(\Think\Exception $e)
        {
            echo "WordLogic error:" . $e->getMessage();
            return false;
        }
       
    }
}