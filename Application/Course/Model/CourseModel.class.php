<?php
/**
 * 课程管理
 */
namespace Course\Model;

use Yunzhi\Model\YunzhiModel;
use TestPercent\Logic\TestPercentLogic;
use KlassCourse\Logic\KlassCourseLogic;
use Word\Logic\WordLogic;

class CourseModel extends YunzhiModel
{
    protected $orderBys         = array("title"=>"desc");  // 排序字段方式
    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new KlassCourseLogic,
                new TestPercentLogic,
                new WordLogic
            );
        }
        if (empty($this->dependencies))
        {
            $this->dependencies = array(
                new WordLogic
            );
        }
        return parent::prepareDelete($options);
    }


    public function saveListTest($data)
    {
        //判断是否为添加
        if ((int)$data[id] === 0)
        {
            //添加的话取返回的id
            $id = parent::saveList($data);

            //添加学前测，阶段测
            $beforeTestdata = array('course_id' =>$id ,'type' =>0 ,'percent' =>0);
            $stageTestdata1 = array('course_id' =>$id ,'type' =>2 ,'percent' =>50);
            $stageTestdata2 = array('course_id' =>$id ,'type' =>2 ,'percent' =>100);

            $TestPercentL = new TestPercentLogic();

            $TestPercentL->saveList($beforeTestdata);
            $TestPercentL->saveList($stageTestdata1);
            $TestPercentL->saveList($stageTestdata2);
        }
        else
        {
            parent::saveList();
        }
    }
}
