<?php
/**
 * 单词属性关系模块
 */
namespace WordWordNature\Logic;

use WordWordNature\Model\WordWordNatureModel;

class WordWordNatureLogic extends WordWordNatureModel
{
    /**
     * 保存扩展信息数据
     * 1.删除原有的数据
     * 2. 依次添加新的数据 
     * @param  int $wordId          单词id
     * @param  list $wordNatureIds          单词扩展属性ID 一维数组
     * @param  list $wordWordNatureTitles   单词扩展标题 一维数组
     * @param array $wordWordNatureExplains 单词扩展释义
     * @return                   
     * panjie
     */
    public function saveLists($wordId, $wordNatureIds, $wordWordNatureTitles, $wordWordNatureExplains)
    {
        //传入的属性值与数值个数不相符，退出
        if (count($wordNatureIds) !== count($wordWordNatureTitles))
        {
            $this->setError("wordNatureIds count not eq wordWordNatureTitles count");
            return false;
        }

        //删除原有数据
        $map = array();
        $map['word_id'] = (int)$wordId;
        $this->where($map)->delete();

        //依次添加新数据 
        $data = array();
        $data['word_id'] = (int)$wordId;
        foreach ($wordNatureIds as $key => $wordWordNatureId)
        {
            //拼接数据,如果值为空，则跳过
            $data['title'] = $wordWordNatureTitles[$key];
            $data['word_nature_id'] = $wordWordNatureId;
            $data['explain'] = isset($wordWordNatureExplains[$key]) ? $wordWordNatureExplains[$key] : '';
            if (trim($wordWordNatureId) !== "" && $this->saveList($data) === false)
            {
                return false;
            }
            continue;
        }
    }
}