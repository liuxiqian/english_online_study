<?php
namespace Home\Model;

use WordWordNature\Model\WordWordNatureModel;
/**
 * 单词扩展属性
 */
class WordWordNature
{
    public $id             = 0;
    public $title          = '';           // 标题
    public $wordNatureId   = 0;            // 单词属性ID
    public $WordNature     = null;         // 单词属性
    public $explain        = '';            // 释义
    public function __construct($id = 0)
    {
        $id = (int)$id;
        $WordWordNatureM    = new WordWordNatureModel();
        $list               = $WordWordNatureM->where('id=' . $id)->find();
        $this->id           = (int)$list['id'];
        $this->title        = (string)$list['title'];
        $this->wordNatureId = (int)$list['word_nature_id'];
        $this->explain      = (string)$list['explain'];
        unset($WordWordNatureM);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getWordNatureId()
    {
        return $this->wordNatureId;
    }

    /**
     * 获取属性类别信息
     * @return WordNature 
     * @author  panjie 
     */
    public function getWordNature()
    {
        if ($this->WordNature === null)
        {
            $this->WordNature = new WordNature($this->getWordNatureId());
        }
        return $this->WordNature;
    }
}