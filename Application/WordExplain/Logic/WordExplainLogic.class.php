<?php
/**
 * 单词扩展信息
 */
namespace WordExplain\Logic;

use WordExplain\Model\WordExplainModel;

class WordExplainLogic extends WordExplainModel
{
    
    public function saveLists($datas)
    {
        $map = array();
        $map['word_id'] = (int)$datas['id'];

        try
        {
            //删除原有的信息
            $this->where($map)->delete();
            
            $list['type'] = $type;
            $list['word_id'] = $datas['id'];
            foreach($datas['explain'] as $data)
            {
                //如果数据为空，则跳出本次循环。
                if (trim($data) === "")
                {
                    continue;
                }

                //添加数据
                $list['value'] = $data;
                if ($this->create($list))
                {
                    $this->add();
                }
                else
                {
                    $this->setError("Data create false");
                    return false;
                }
            }
            return true;
        }
        catch(\Think\Exception $e)
        {
            $this->setError("Database connect error");
            return false;
        }
        
    }

        
    public function deleteListByWordId($wordId)
    {
        $map = array("word_id"=>(int)$wordId);
        return $this->where($map)->delete();
    }
}