<?php
/*
学习榜样类
liuxi
 */
namespace Home\Model;

use Home\Model\Student;
use Student\Logic\StudentLogic;     // 学生

use Hero\Logic\HeroLogic;

class Hero extends Student
{
    private $HeroStudents = null;       // 我的学习榜样
    private $BeHeroStudents = null;     // 我是学习榜样
    private $Heros = null;              // 可设置的学习榜样列表 Student
    private $totalCount = 0;            // 总记录数

    public function __construct($data = 0)
    {
        $data = (int)$data;
        parent::__construct($data);
    }

    public function setTotalCount($totalCount)
    {
        $this->totalCount = (int)$totalCount;
    }

    public function getTotalCount()
    {
        return (int)$this->totalCount;
    }

    public function getStudent()
    {
        return $this->Student;
    }

    /**
     * 判断传入的学生是否是我的学习榜样
     * @param  Student $Student 学生
     * @return 0,1          
     * @author  panjie
     */
    public function getIsHero(Hero $Hero)
    {
         $HeroL = new HeroLogic();
         $map['student_id'] = $this->getId();
         $map['hero_student_id'] = $Hero->getId();
         $data = $HeroL->where($map)->find();
         unset($HeroL);
         if ($data === null)
         {
            return false;
         }
         else
         {
            return true;
         }
    }

    /**
     * 获取为用于JSON数据的真假值  
     * @param  Hero   $Hero 榜样  
     * @return 'false' 'true'
     * @author panjie 
     */
    public function getIsHeroJson(Hero $Hero)
    {
        if ($this->getIsHero($Hero))
        {
            return 'true';
        }
        else
        {
            return 'false';
        }
    }

    //获取我的学习榜样列表
    public function getHeroStudents()
    {
        if ($this->heroStudents === null)
        {
            $this->heroStudents = array();
            if ($this->getHeroIsSelf())
            {
                $this->heroStudents[] = $this;
            }
            else
            {
                $lists = array();
                $map = array();
                $HeroL = new HeroLogic();
                $map['student_id'] = $this->getId();
                $lists = $HeroL->where($map)->select();
                foreach($lists as $list)
                {
                    $HeroObj = new Hero($list['hero_student_id']);

                    // 只显示愿意成为学习榜样的学生
                    if ($HeroObj->getWishExample() == 0)
                    {
                        $this->heroStudents[] = $HeroObj;
                    }
                }
                unset($HeroL);
            }
        }
        
        return $this->heroStudents;
    }

    //获取我是学习榜样列表
    public function getBeHeroStudents()
    {
        $lists = array();
        $result = array();
        $map = array();
        $HeroL = new HeroLogic();
        $map['hero_student_id'] = $this->getId();
        $lists = $HeroL->where($map)->select();
        foreach($lists as $list)
        {
            $StudentObj = new Student($list['student_id']);
            $result[] = $StudentObj;
        }
        return $result;
    }

    //获取我是学习榜样条数
    public function getBeHeroStudentsCounts()
    {
        $count = array();
        $map = array();
        $HeroL = new HeroLogic();
        $map['hero_student_id'] = $this->Student->getId();
        $count = $HeroL->where($map)->count();
        return $count;
    }

    /**
     * 添加榜样
     * @param object 学生类
     * @return bool 添加成功返回true，失败返回false
     */
    public function add(Student $Student)
    {
        $data = array();
        $HeroL = new HeroLogic();
        $data['student_id'] = $this->Student->getId();
        $data['hero_student_id'] = $Student->getId();
        if($HeroL->create($data))
        {
            $HeroL->add();
            return true;
        }
        else
        {
            E("数据添加错误".$HeroL->getError);
        }
    }

    /**
     * 删除榜样
     * @param object 学生类
     * @return bool 删除成功返回删除条数,失败返回false
     */
    public function delete(Student $Student)
    {
        $data = array();
        $HeroL = new HeroLogic();
        $map['student_id'] = $this->Student->getId();
        $map['hero_student_id'] = $Student->getId();
        return $HeroL->where($map)->delete();
    }

    /**
     * 获取可设置的榜样列表
     * @return array Student
     */
    public function getHeros()
    {   
        if ($this->Heros === null)
        {
            $map = array();
            $map['is_hero'] = 0;        // 找所有愿意成为学习榜样的

            // 和本班同学比
            if ($this->getPlayWithWhoes() == false)
            {
                $map['klass_id'] = $this->getKlass()->getId();
            }

            // 查询数据，并设置总条数
            $StudentL = new StudentLogic();
            $lists = $StudentL->addMaps($map)->getLists();
            $this->setTotalCount($StudentL->getTotalCount()); 

            $this->Heros = array();
            foreach ($lists as $list)
            {
                try
                {
                    $Hero = new Hero($list['id']);
                    $this->Heros[] = $Hero;
                }
                catch (\Think\Exception $e)
                {
                    // 如果没有此学生则跳过
                }
                
            }
        }
        return $this->Heros;
    }

    
    /**
     * 改变学习榜样是否为自己
     * @return  
     */
    public function setHeroIsSelf($value)
    {
        $data = array();
        $data['id'] = $this->getId();
        $data['hero_is_self'] = (int)$value ? 1 : 0;
        $StudentL = new StudentLogic;
        return $StudentL->saveList($data);
    }

    /**
     * 切换榜样信息，即如果已经是榜样了，就删除，如果还不是榜样，就增加
     * @param  integer $heroId 榜样ID
     * @return           
     * @author  panjie 
     */
    public function toggleHero($heroId = 0)
    {
        $heroId = (int)$heroId;
        $Hero = new Hero($heroId);
        if ($Hero->getId() == 0)
        {
            E('传入的ID信息不存在');
        }

        $HeroL = new HeroLogic;
        $map = array();
        $map['student_id'] = $this->getId();
        $map['hero_student_id'] = $Hero->getId();
        $data = $HeroL->where($map)->find();
        if ( $data !== null)
        {
            return $HeroL->where($map)->delete();
        }
        else
        {
            return $HeroL->saveList($map);
        }

    }
}