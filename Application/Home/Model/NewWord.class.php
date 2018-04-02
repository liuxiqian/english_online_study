<?php
/**
* 前台
* 生词
* anqiang
*/
namespace Home\Model;

use NewWord\Logic\NewWordLogic;

class NewWord extends Word
{
    /**
     * 移除生词
     * @param object 学生类
     * @return int 移除成功返回成功移除条数
     */
    public function remove(Student $Student)
    {
        $NewWordL = new NewWordLogic();
        $map = array();
        $map['student_id'] = $Student->getId();
        $map['word_id'] = $this->getId();
        return $NewWordL->where($map)->delete();
    }

    /**
     * 添加生词
     * @param object 学生类
     * @return bool 添加成功返回true，失败返回false
     */
    public function add(&$Student)
    {
        $NewWordL= new NewWordLogic;
        $data = array();
        
        // 先判断这个单词是否是该学生的生词
        // 是，则更新时间，无则添加新记录
        if (!$this->isNewWord($Student))
        {
            $data['id']     = $this->getId();
        } else {
            $data = $this->makeMap($Student);
        }
        return $NewWordL->saveList($data);
    }

    /**
     * 判断该单词是否是该学生的生词 
     * @param  Student  &$Student 学生
     * @return boolean        
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function isNewWord(&$Student)
    {
        $NewWordL= new NewWordLogic;
        $map = $this->makeMap($Student);
        if (null === $NewWordL->where($map)->find())
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 生成map查询或更新信息
     * @param  Student &$Student 学生
     * @return array           
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function makeMap(&$Student)
    {
        $map                = array();
        $map['word_id']     = $this->getId();
        $map['student_id']  = $Student->getId();
        return $map;
    }

    /**
     * 获取下一个生词，学生在生词学习时用到
     * @param $Student object
     * @return $Word object
     */
    static public function getNextNewWord(Student &$Student)
    {
        //该学生生词表的数据
        $map = array();
        $map['student_id'] = $Student->getId();
        $NewWordL = new NewWordLogic();
        $count = $NewWordL->where($map)->count();
        $index = rand(1, $count) - 1;

        $lists = $NewWordL->field('word_id')->where($map)->limit($index,1)->select();//该学生的生词列表
        $Word = new Word($lists[0]['word_id']);
        
        unset($NewWordL);
        unset($lists);

        return $Word;
    }
}