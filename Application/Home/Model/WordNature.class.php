<?php
namespace Home\Model;

use WordNature\Model\WordNatureModel;

/**
 * 单词属性
 */
class WordNature
{
    public $id      = 0;         // ID
    public $title   = '';        // 标题

    public function __construct($id = 0)
    {
        $id = (int)$id;
        $WordNatureM = new WordNatureModel();
        $list = $WordNatureM->where('id=' . $id)->find();
        $this->id = (int)$list['id'];
        $this->title = (string)$list['name'];
        unset($WordNatureM);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
}