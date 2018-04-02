<?php
/**
 * 单词进度登陆单词课程视图
 * anqiang
 */
namespace WordProgressLoginWordCourseView\Logic;

use WordProgressLoginWordCourseView\Model\WordProgressLoginWordCourseViewModel;
use TestStudentTestPercentCourseView\Logic\TestStudentTestPercentCourseViewLogic;
use KlassCourseStudentView\Logic\KlassCourseStudentViewLogic;//为取某学生的所有课程
use Word\Logic\WordLogic;   //为获取某门课程的单词总数

use Home\Model\Course;
use Home\Model\Student;

class WordProgressLoginWordCourseViewLogic extends WordProgressLoginWordCourseViewModel
{
    protected static $self;
    protected $timeInterval = 120;  //有效学习时间间隔。我们认为，当学习两个单词间的时间大于 有效学习时间间隔 时，不记入有效学习时间。 当学习两个单词的间隔小于等于 有效学习时间间隔时，记入有效学习时间

    protected $stageTestPassedGrade = 80;  //阶段测试通过成绩
    protected $TestStudentTestPercentCourseViewL = null;
    protected $KlassCourseStudentViewL = null;
    protected $WordL = null;
    
    public function __construct()
    {
        parent::__construct();
        // 进行有效学习时间间隔的初始化
        if ((int)C("YUNZHI_TIME_INTERVAL") !== 0)
        {
            $this->timeInterval = (int)C("YUNZHI_TIME_INTERVAL");
        }
    }

    public static function getCurrentObject() {
        if (is_null(self::$self)) {
            self::$self = new self();
        }

        return self::$self;
    }

    public function getTestStudentTestPercentCourseViewL()
    {
        if (is_null($this->TestStudentTestPercentCourseViewL)) {
            $this->TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();
        }

        return $this->TestStudentTestPercentCourseViewL;
    }

    public function getKlassCourseStudentViewL()
    {
        if (is_null($this->KlassCourseStudentViewL)) {
            $this->KlassCourseStudentViewL = new KlassCourseStudentViewLogic();
        }

        return $this->KlassCourseStudentViewL;
    }

    public function getWordL()
    {
        if (is_null($this->WordL)) {
            $this->WordL = new WordLogic();
        }

        return $this->WordL;
    }
    /**
     * 取两单词之间的有效间隔
     * @author xulinjie
     * @return int
     */
    public function getTimeInterval()
    {
        return $this->timeInterval;
    }

    /**
     * 根据学生id获取班级名称
     * @param int 学生id
     * @return string 班级名称
     * anqiang
     */
    public function getKlassNameByStudentId($studentId)
    {
        $map = array();
        $map['student__id'] = $studentId;
        $data = $this->getKlassCourseStudentViewL()->where($map)->find();
        return $data['name'];
    }

    /**
     * 根据id获取学生姓名
     * @param int 学生id
     * @return string 学生姓名
     * anqiang
     */
    public function getStudentNameByStudentId($studentId)
    {
        $map = array();
        $map['student__id'] = $studentId;
        $data = $this->getKlassCourseStudentViewL()->where($map)->find();
        return $data['student__name'];
    }
    /**
     * 获取 某学生的所有课程
     * @param int 学生id
     * @return array(course)
     * anqiang
     */
    public function getCoursesByStudentId($studentId)
    {
        $map['student__id'] = $studentId;
        return $this->getKlassCourseStudentViewL()->where($map)->group('course_id')->select();
    }

    /**
     * 获取某个学生学习情况
     */
    public function getLearnByStudentId($studentId)
    {
        $map['login__student_id'] = $studentId;
        $data = $this->where($map)->group('login__time')->select();
        return $data;
    }

    /**
     * 获取  某学生 在某门课程中的学习次数
     * @param int 课程id
     * @param int 学生id
     * @return int  学习次数
     * anqiang
     */
    public function getLearnTimesByCourseIdStudentId($courseId, $studentId)
    {
        $map['word__course_id'] = $courseId;
        $map['login__student_id'] = $studentId;
        $data = $this->distinct(true)->where($map)->field('login_time')->group('login__time')->count();
        echo $this->getLastSql();
        return $data;
    }

    /**
     * 获取 某学生 在某门课程 中，首次学习的时间 
     * @param  int $courseId  课程ID
     * @param  int $studentId 学生ID
     * @return time 不存在返回0 时间戳 
     * anqiang
     */
    public function getFirstTimeByCourseIdStudentId($courseId, $studentId)
    {
        $map['login__student_id'] = $studentId;
        $map['word__course_id'] = $courseId;
        $data = $this->where($map)->order(array('time'=>'asc'))->find();
        if ($data === null)
            return 0;
        else
            return $data['time'];
    }

    /**
     * 获取 某学生 在某门课程 中，最后一次学习的学习时间(上次学习)
     * @param  int $courseId  课程ID
     * @param  int $studentId [description]
     * @return time 不存在记录返回0      时间戳
     * anqiang
     */
    public function getLastTimeByCourseIdStudentId($courseId, $studentId)
    {
        $map['login__student_id'] = $studentId;
        $map['word__course_id'] = $courseId;
        $data = $this->where($map)->order(array('time'=>'desc'))->find();
        if ($data === null)
            return 0;
        else
            return $data['time'];
    }

    /**
     * 获取 某学生 在某门课程中， 最后一次学习，所关取的登陆ID
     * @param  int $courseId  课程ID
     * @param  INT $studentId 学生ID
     * @return INT            登陆ID
     * anqiang
     */
    private function _getLastLoginIdByCourseIdStudentId($courseId, $studentId)
    {
        $map['word__course_id'] = $courseId;
        $map['login__student_id'] = $studentId;
        $data = $this->where($map)->order(array('login__time'=>'asc'))->find();
        return $data['login_id'];
    }

    /**
     * 获取 某学生 在某门课程中，最后一次学习用的总时长（上次用时）
     * @param  int $couserId  课程ID
     * @param  int $studentId 学生ID
     * @return int(分)  学习分钟数
     * anqiang
     */
    public function getLastTimeCostByCourseIdStudentId($courseId, $studentId)
    {
        //获取最后一次学习的 登陆ID
        $loginId = $this->_getLastLoginIdByCourseIdStudentId($courseId, $studentId);
        
        //根据登陆ID，课程ID，学生ID，获取所有记录，并计算有效学习时长
        $map['login_id'] = $loginId;
        $map['word__course_id'] = $courseId;
        $map['login__student_id'] = $studentId;
        $datas = $this->where($map)->order(array('time'=>'asc'))->select();
        $temp = 0;
        $minus = 0;
        $sum = 0;
        foreach ($datas as $key => $value) 
        {
            $minus = $value['time'] - $temp;
            if($minus <= $this->timeInterval)  //若两次学习的时间间隔小于合理间隔，则认为是有效学习，计入$sum
            {
                $sum = $minus + $sum;
            }
            $temp = $value['time'];
        }
        return floor($sum/60 + 0.5);

    }

    /**
     * 获取 某学生 在某门课程中，总共的学习时长
     * @param  int $courseId  课程ID
     * @param  int $studentId 学生ID
     * @return int(分)            学习分钟数
     * anqiang
     */
    public function getTotalTimeCostByCourseIdStudentId($courseId, $studentId)
    {
        $map['word__course_id'] = $courseId;
        $map['login__student_id'] = $studentId;
        $datas = $this->where($map)->order(array('time'=>'desc'))->select();
        $temp = $datas[0]['time'];
        $sum = 0;
        foreach ($datas as $key => $value) 
        {
            $minus = $temp - $value['time'];
            if($minus <= $this->timeInterval)  //若两次学习的时间间隔小于合理间隔，则认为是有效学习，计入$sum
            {
                $sum += $minus + $sum;
            }
            $temp = $value['time'];
        }
        unset($key);
        unset($value);
        
        unset($map);
        unset($datas);
        unset($temp);
        return floor($sum/60 + 0.5);
    } 


    /**
     * 获取 某学生 在某门课程中， 新学的单词个数
     * @param  int $courseId  课程ID
     * @param  int $studentId 学生ID
     * @return int
     * anqiang          
     */
    public function getNewWordCountByCourseIdStudentId($courseId, $studentId)
    {
        $StudentCourse = new StudentCourse(new Course($courseId), new Student($studentId));
        $newWordCount = $StudentCourse->getNewStudyWordsCount();
        unset($StudentCourse);
        return $newWordCount;
    }

    /**
     * 获取 某学生 在某门课程中， 复习的单词个数
     * @param  int $courseId  课程ID
     * @param  int $studentId 学生ID
     * @return int
     * anqiang 
     */
    public function getOldWordCountByCourseIdStudentId($courseId, $studentId)
    {
        $StudentCourse = new StudentCourse(new Course($courseId), new Student($studentId));
        $oldStudyWordsCount = $StudentCourse->getOldStudyWordsCount();
        unset($StudentCourse);
        return $oldStudyWordsCount;
    }  

    /**
     * 获取 某学生 某门课程 的剩余词汇个数
     * 根据某门课程的测试百分比来算，通过某测试则认为是非剩余单词
     * @param int 课程id
     * @param int 学生id
     * @return int 剩余词汇个数
     * anqiang
     */
    public function getSurplusWordByCourseIdStudentId($courseId,$studentId)
    {
        $StudentCourse = new StudentCourse(new Course($courseId), new Student($studentId));
        $remainCount = $StudentCourse->getRemainCount();
        unset($StudentCourse);
        return $remainCount;
    }

    /**
     * 获取 某学生 某门课程的进度，根据这门课程的测试百分比最大的来算
     * @param int 学生id
     * @param int 课程id
     * @return int 进度
     * anqiang
     */
    public function getProgressByCourseIdStudentId($courseId,$studentId)
    {
        $map['course__id'] = $courseId;
        $map['student__id'] = $studentId;
        $datas = $this->getTestStudentTestPercentCourseViewL()->where($map)->select();
        if (empty($datas) === true)
            return 0;
        else
        {
            $maxPercent = (int)$datas[0]['percent'];    //初始化最大百分比
            foreach ($datas as $key => $value) 
            {
                if($maxPercent <= $value['percent'])    //循环判断该学生测试的百分比是否比$maxPercent
                {
                    $maxPercent = $value['percent'];
                }
            }
            return $maxPercent;
        }
    }

    /**
     * 获取 某学生 某门课程 的第一阶段测 初试成绩
     * @param   int 学生id
     * @param   int  课程id
     * @return  int
     * anqiang
     */
    public function getFirstStageTestGradeByCourseIdStudentId($courseId,$studentId)
    {
        $map['course__id'] = $courseId;
        $map['student__id'] = $studentId;
        $map['type'] = 2;
        $data = $this->getTestStudentTestPercentCourseViewL()->where($map)->order(array("percent" => "asc","time"=>"asc"))->find();
        if ($data === null)
            return 0;
        else
            return $data['grade'];
    }

    /**
     * 获取 某学生 某门课程 第一阶段测 的通过成绩
     * @param int 学生id
     * @param int 课程id
     * @return int 通过成绩  若未通过返回0
     * anqiang
     */
    public function getFirstStageTestPassedGradeByCourseIdStudentId($courseId,$studentId)
    {
        $map['course__id'] = $courseId;
        $map['student__id'] = $studentId;
        $map['type'] = 2;
        $data = $this->getTestStudentTestPercentCourseViewL()->where($map)->order(array("percent" => "desc"))->find();    //为了取第一阶段测的percent值
        // dump($data);
        if($data === null)
            return 0;
        else
        {
            $map['percent'] = $data['percent'];  //取第一阶段测的percent值
            $datas =  $this->getTestStudentTestPercentCourseViewL()->where($map)->select();//取所有该学生该课程的第一阶段测数据
            $maxGrade = (int)$datas[0]['grade'];
            foreach ($datas as $key => $value) {
            # code...
                if ($value['grade'] > $maxGrade)
                {
                    $maxGrade = $value['grade'];
                }   
            }
            if ($maxGrade >= $this->stageTestPassedGrade)
                return $maxGrade;
            else
                return 0;
        }
    }


    /**
     * 获取 某学生 某门课程 的第一阶段测试的次数
     * @param int 学生id
     * @param int 课程id
     * @return int 次数
     * anqiang
     */
    public function getFirstStageTestCountByCourseIdStudentId($courseId,$studentId)
    {
        $map['course__id'] = $courseId;
        $map['student__id'] = $studentId;
        $map['type'] = 2;
        $data = $this->getTestStudentTestPercentCourseViewL()->where($map)->order(array("percent" => "asc"))->find();
        if ($data === null)
            return 0;
        else
        {
            $map['percent'] = $data['percent'];
            return $this->getTestStudentTestPercentCourseViewL()->where($map)->count();
        }
        
    }

    /**
     * 获取 某学生 某门课程 的第二阶段测 初试成绩
     * @param   int 学生id
     * @param   int  课程id
     * @return  int 成绩
     * anqiang
     */
    public function getSecondStageTestGradeByCourseIdStudentId($courseId,$studentId)
    {
        $map['course__id'] = $courseId;
        $map['student__id'] = $studentId;
        $map['type'] = 2;
        $datas = $this->getTestStudentTestPercentCourseViewL()->where($map)->group("percent")->order(array("percent" => "asc"))->select();  //$datas[]['percent']是各阶段侧的percent
        if((int)$datas[1]['percent'] === 0)
            return 0;
        else
        {
            $map['percent'] = $datas[1]['percent'];
            $data = $this->getTestStudentTestPercentCourseViewL()->where($map)->order(array("time" => "asc"))->find();
            return $data['grade'];
        }
    }

    /**
     * 获取 某学生 某门课程 第一阶段测 的通过成绩
     * @param int 学生id
     * @param int 课程id
     * @return int 通过成绩  若未通过返回0
     * anqiang
     */
    public function getSecondStageTestPassedGradeByCourseIdStudentId($courseId,$studentId)
    {
        $map['course__id'] = $courseId;
        $map['student__id'] = $studentId;
        $map['type'] = 2;
        $datas = $this->getTestStudentTestPercentCourseViewL()->where($map)->group("percent")->order(array("percent" => "asc"))->select();  //$datas[]['percent']是各阶段侧的percent
        if((int)$datas[1]['percent'] === 0)
            return 0;   //无第二阶段测
        else
        {
            $map['percent'] = $datas[1]['percent'];
            $datas = $this->getTestStudentTestPercentCourseViewL()->where($map)->select();
            $maxGrade = (int)$datas[0]['grade'];
            foreach ($datas as $key => $value) {
                if ($value['grade'] > $maxGrade)
                {
                    $maxGrade = $value['grade'];
                }
            }
            if ($maxGrade >= $this->stageTestPassedGrade)
                return $maxGrade;
            else
                return 0;
        }
        
    }

    /**
     * 获取 某学生 某门课程 的第一阶段测试的次数
     * @param int 学生id
     * @param int 课程id
     * @return int 次数
     * anqiang
     */
    public function getSecondStageTestCountByCourseIdStudentId($courseId,$studentId)
    {
        $map['course__id'] = $courseId;
        $map['student__id'] = $studentId;
        $map['type'] = 2;
        $datas = $this->getTestStudentTestPercentCourseViewL()->where($map)->group("percent")->order(array("percent" => "asc"))->select();  //$datas[]['percent']是各阶段侧的percent
        if((int)$datas[1]['percent'] === 0)
            return 0;   //无第二阶段测
        else
        {
            $map['percent'] = $datas[1]['percent'];
        }
        return $this->getTestStudentTestPercentCourseViewL()->where($map)->count();
    }
    
}