<?php
/**
 * 学生类
 * xulinjie
 * 2016.04.25
 */

namespace Home\Model;

use Student\Logic\StudentLogic;     //学生表
use Login\Logic\LoginLogic;         //登录表
use KlassCourseStudentView\Logic\KlassCourseStudentViewLogic;
use WordProgressLoginView\Logic\WordProgressLoginViewLogic;
use Hero\Logic\HeroLogic;           //学习榜样
use Admin\Model\Test\BaseModel;     //测试小模型
use KlassCourse\Logic\KlassCourseLogic;     // 班级课程
use TestStudentTestPercentCourseView\Logic\TestStudentTestPercentCourseViewLogic;//测试 学生 测试百分比 课程视图
use StudentWordStudyNode\Model\StudentWordStudyNodeModel;   // 学生当前学习的节点记录 记录学习的进度

class Student extends Model
{
    private static $StudentLogic = NULL;       // 学生逻辑层
    public $data = ['_class' => __CLASS__];    // 增加_class属性，用于缓存序列化
    protected $courseCount;
    protected $studyTime;
    protected $totalStudyMin;
    private $Card = NULL;       //通过Card对象去获取对应的CardBatch再去得到其effective_days
    private $totalStudyCount = NULL;        // 词汇量
    private $minGrade = 0;        // 前测成绩
    private $maxGrade = 0;        // 后测成绩
    private $IndexOfFatigue = NULL;     //疲劳指数
    private $Klass = NULL;    //班级
    private $Attachment = NULL;        //附件
    private $studyCourses = NULL;     // type:Course最近学习的课程（实现为已学的课程）

    public function __construct($data = null)
    {
        if (!is_null($data)) {
            if (is_array($data)) {
                $this->setData($data);
            } else {
                $data = (int)$data;
                if ($data === 0) {
                    $this->isDefault = TRUE; // id为0，
                } else {
                    $student = $this->getStudentLogic()->where("id=$data")->find();
                    if ($student === NULL) {
                        E('不存在ID为' . $data . '的学生信息');

                        return;
                    } else {
                        $this->data = $student;
                        $this->data['play_with_whoes'] = (int)$student['compare'];
                        $this->data['wish_example'] = (int)$student['is_hero'];
                        $this->data['attachment_id'] = $student['image_attachment_id'];
                    }
                }
            }
        }
    }

    public function getStudentLogic() {
        if (is_null(self::$StudentLogic)) {
            self::$StudentLogic = new StudentLogic();
        }

        return self::$StudentLogic;
    }

    //获取本类对象的性别

    static public function login(Student $Student)
    {
        session("studentId", $Student->getId());

        // 将登陆信息存库
        Login::Login($Student);
    }


    //获取本类对象的课程数

    /**
     * 验证用户名密码是否正确
     * @return 正确返回 Student，错误：Student(0)
     * panjie
     */
    static public function validate($username, $password)
    {
        $map = array();
        $map['username'] = trim($username);

        $student = self::getStudentLogic()->where($map)->find();
        if ($student !== NULL && (StudentLogic::makePassword(trim($password)) === $student['password'])) {
            return new Student($student['id']);
        } else {
            return new Student(0);
        }
    }

//获取本类对象的学习次数

    /**
     * 获取登陆的 学生
     * @return Student
     * 存在登陆，则返回登陆的学生。不存在，则返回ID为0的学生
     * panjie
     * @throws \think\Exception
     */
    static public function getLoginStudent()
    {
        if (session('studentId') === NULL) {
            return new Student(0);
        } else {
            try {
                session('studentId', session('studentId'));

                return new Student(session('studentId'));
            } catch (\think\Exception $e) {
                self::logOut();
                throw $e;
            }
        }
    }

//获取本类对象的总的学习时长（分钟）

    static public function logOut()
    {
        session("studentId", NULL);
    }

    public function getSex()
    {
        return (int)$this->getData('sex');
    }

    //获取本类对象的上次学习时间

    public function getCourseCount()
    {
        return $this->getKlass()->getCourseCount();
    }


    //获取本类对象的卡密信息

    public
    function getKlass()
    {
        if ($this->Klass === NULL) {
            $this->Klass = new Klass($this->klassId);
        }

        return $this->Klass;
    }

    /**
     * 获取学习次数
     * @return int|mixed|string
     * Create by panjie@yunzhiclub.com
     */
    public function getStudyTime()
    {
        if (null === $this->studyTime) {
            $this->studyTime = Cache::get(__CLASS__, __METHOD__, $this->getId());
            if (false === $this->studyTime) {
                $LoginL = new LoginLogic();
                $this->studyTime = $LoginL->getCountByStudentId($this->getId());
                Cache::set(__CLASS__, __FUNCTION__, $this->getId(), $this->studyTime);
            }
        }

        return $this->studyTime;
    }

    /**
     * @return int|mixed|string
     * Create by panjie@yunzhiclub.com
     * 累计学习分钟数
     */
    public function getTotalStudyMin()
    {
        if (is_null($this->totalStudyMin)) {
            $this->totalStudyMin = Cache::get(__CLASS__, __FUNCTION__, $this->getId());
            if (FALSE === $this->totalStudyMin) {
                $WordProgressLoginViewL = new WordProgressLoginViewLogic();
                $this->totalStudyMin = $WordProgressLoginViewL->getTotalTimeCostByStudentId($this->getId());
                Cache::set(__CLASS__, __FUNCTION__, $this->getId(), $this->totalStudyMin);
                unset($WordProgressLoginViewL);
            }
        }

        return $this->totalStudyMin;
    }

//获取本类对象是否为默认对象

    public
    function getIndexOfFatigueId()
    {
        return $this->indexOfFatigueId;
    }

//获取本类对象的登录信息

    public
    function getLastStudyTime()
    {
        //上次学习时间
        $LoginL = new LoginLogic();
        $this->lastStudyTime = $LoginL->getLastLoginTimeByStudentId($this->id);

        return $this->lastStudyTime;
    }


//获取本类对象的成为榜样的数量

    public
    function getIsExpire()
    {
        if ($this->isExpire === NULL) {
            if (time() > $this->getDeadLine())
                $this->isExpire = TRUE;
            else
                $this->isExpire = FALSE;
        }

        return (bool)$this->isExpire;
    }

//获取本类对象的需要学习的总单词数

    /**
     * 获取有效期
     * @return int
     * panjie
     */
    public
    function getDeadLine()
    {
        if ($this->deadLine === NULL) {
            $days = $this->getCard()->getCardBatch()->getEffectiveDays();
            $this->deadLine = $days * 24 * 60 * 60 + $this->getCreationDate();
        }

        return $this->deadLine;
    }

//获取本类对象的学习速度

    public
    function getCard()
    {
        if ($this->Card === NULL) {
            $this->Card = new Card($this->id);
        }

        return $this->Card;
    }

    public
    function getIsDefault()
    {
        return (bool)$this->isDefault;
    }

    public
    function getCurrentLogin()
    {
        if (NULL === $this->currentLogin) {
            $map['student_id'] = $this->id;
            $LoginL = new LoginLogic();
            $data = $LoginL->where($map)->order(array('time' => 'desc'))->find();
            $this->currentLogin = new Login($data['id']);
            unset($LoginL);
        }

        return $this->currentLogin;
    }

    public
    function getBeHeroNumber()
    {
        $map = array();
        $map['hero_student_id'] = $this->id;
        $HeroL = new HeroLogic();
        $count = $HeroL->where($map)->count();

        return $count;
    }

    /**
     * 取本类对象班级里面词汇量的信息
     * @author xulinjie
     * @return array
     */
    public
    function getWordCountRank()
    {
        if (NULL === $this->wordCountRank) {
            $map['klass_id'] = $this->klassId;

            //取本类对象同班级的对象
            $lists = $this->getStudentLogic()->where($map)->field('id')->select();
            $sameCourseStudnts = array();
            foreach ($lists as $list) {
                $Student = new Student($list);
                $Student->getCurrentWordCount();    //计算当前词汇量
                $sameCourseStudnts[] = $Student;
            }
            $this->wordCountRank = ArraySort($sameCourseStudnts, 'currentWordCount', 'DESC', 'num');
        }

        // dump($wordCountRanks);
        return $this->wordCountRank;

    }

    /**
     * 取本类对象的当前词汇量
     * @author xulinjie
     * @return int
     */
    public
    function getCurrentWordCount()
    {
        if ($this->currentWordCount === NULL) {
            $count = $this->getTotalStudyCount();
            $speed = $this->getStudySpeed() / 100;
            $this->currentWordCount = (int)floor(($count * $speed) + 0.5);
        }

        //测试数据
        // if ($this->id == 1) {
        //     $this->currentWordCount = 33;
        // }
        // if ($this->id == 2) {
        //     $this->currentWordCount = 33;
        // }
        // if ($this->id == 3) {
        //     $this->currentWordCount = 22;
        // }
        // if ($this->id == 4) {
        //     $this->currentWordCount = 55;
        // }
        return $this->currentWordCount;
    }

//获取本类对象的学前测

    public
    function getTotalStudyCount()
    {
        if ($this->totalStudyCount === NULL) {
            $KlassCourseStudentViewL = new KlassCourseStudentViewLogic();
            $this->totalStudyCount = $KlassCourseStudentViewL->getAllWordNumByStudentId($this->id);
        }

        return $this->totalStudyCount;
    }

//获取本类对象的学后测

    public
    function getStudySpeed()
    {
        if ($this->studySpeed === NULL) {
            $TestStudentTestPercentCourseViewL = new TestStudentTestPercentCourseViewLogic();
            $this->studySpeed = (int)$TestStudentTestPercentCourseViewL->getProgressByStudentId($this->id);
        }

        return $this->studySpeed;
    }

//获取本类对象的疲劳指数信息

    /**
     * 榜样的总学习进度
     * 取本类对象偶像里面词学习速度的信息
     * @author xulinjie
     * @return array
     */
    public
    function getHeroStudySpeedRanks()
    {
        $HeroL = new HeroLogic();
        $map['student_id'] = $this->id;

        //取本类全部偶像的对象
        $lists = $HeroL->where($map)->field('hero_student_id')->select();
        // dump(empty($lists));

        if (empty($lists)) {
            $heroStudySpeedRanks = array();
        } else {
            foreach ($lists as $list) {
                $StudentObj = new Student($list['hero_student_id']);

                // 只显示愿意成为学习榜样的学生
                if ($StudentObj->getWishExample() == 0) {
                    $sameCourseStudnts[] = $StudentObj;
                }
            }

            //按照学习速度对偶像排名
            $heroStudySpeedRanks = ArraySort($sameCourseStudnts, 'studySpeed', 'DESC', 'num');
        }

        return $heroStudySpeedRanks;
    }

//获取本类对象的班级信息

    /**
     * 当天本类对象班级全部同学的数组对象（包括当天新学单词数）
     * @author xulinjie
     * @return array
     */
    public
    function getCourseNewWordCountRanks()
    {
        if (NULL === $this->courseNewWordCountRanks) {
            $map['klass_id'] = $this->klassId;

            //取本类对象同班级的对象
            $lists = $this->getStudentLogic()->where($map)->field('id')->select();
            $sameCourseStudnts = array();
            foreach ($lists as $list) {
                $Student = new Student($list);
                $Student->getTodayNewWordCount();   //计算当天的新学单词数
                $sameCourseStudnts[] = $Student;
            }

            //按照当天新学单词数排名
            $this->courseNewWordCountRanks = ArraySort($sameCourseStudnts, 'todayNewWordCount', 'DESC', 'num');
        }

        return $this->courseNewWordCountRanks;
    }

    /**
     * 获取本类对象当天新学词汇数
     * @author xulinjie
     * @return int
     */
    public
    function getTodayNewWordCount()
    {
        if (NULL === $this->todayNewWordCount) {
            $beginTime = strtotime(date('Y-m-d', time()));
            $endTime = time();

            $WordProgressLoginViewL = new WordProgressLoginViewLogic();
            $map['student_id'] = $this->getId();
            $map['is_new'] = 1;
            $map['time'] = array(array('egt', $beginTime), array('lt', $endTime));

            $this->todayNewWordCount = (int)$WordProgressLoginViewL->where($map)->count();
        }


        return $this->todayNewWordCount;
    }

    public
    function getMinGrade()
    {
        $M = new BaseModel();
        $this->minGrade = $M->getLearnBeforeTestGradeByStudentId($this->id);

        return $this->minGrade;
    }

//获取本类对象的附件信息

    public
    function getMaxGrade()
    {
        $M = new BaseModel();
        $this->maxGrade = $M->getLearnAfterTestGradeByTimeStudentId($this->id);

        return $this->maxGrade;
    }

    public
    function getIndexOfFatigue()
    {
        if ($this->IndexOfFatigue === NULL) {
            $this->IndexOfFatigue = new IndexOfFatigue($this->indexOfFatigueId);
        }

        return $this->IndexOfFatigue;
    }

    /**
     * 获取二维码
     * @return string 二维码相对于根路径的地址
     * @author panjie <panjie@yunzhiclub.com>
     * @todo 后期我们需要将二维设置为动态获取。
     * 两种方案：
     * 1.临时二维码，该方案将通过对应的公众号的获取临时二维码方法来获取。
     * 2. 永久二维码，该方案将直接获取附件信息。
     * 如果附件无信息，则说明还未获取到这个二维码。
     * 那么调用对应的公众号的获取永久二维码的方法后，将永久二维码做为附件存入。
     */
    public
    function getQrcode()
    {
        return __ROOT__ . '/images/qrcode.jpg';
    }

    public
    function getAttachmentId()
    {
        return $this->attachmentId;
    }

    public
    function getAttachment()
    {
        if ($this->Attachment === NULL) {
            $this->Attachment = new Attachment($this->attachmentId);
        }

        return $this->Attachment;
    }

    /**
     * 获取所有的课程
     * @return array [type] [description]
     */
    public
    function getAllCourses()
    {
        return $this->getKlass()->getAllCourses();

    }

    public
    function getStudyCourses()
    {
        //该学生已学的课程
        if ($this->studyCourses === NULL) {
            $this->studyCourses = [];

            // 查找学习节点表中的记录
            $StudentWordStudyNodeModel = new StudentWordStudyNodeModel;
            $map = [];
            $map['student_id'] = $this->getId();
            $lists = $StudentWordStudyNodeModel->where($map)->select();
            foreach ($lists as $key => $list) {
                if ((int)$list['course_id']) {
                    array_push($this->studyCourses, new Course($list['course_id']));
                }
            }
        }

        return $this->studyCourses;
    }

    /**
     * 获取今日所学的单词总数
     * @return int
     */
    public
    function getTodayStudyCount()
    {
        if ($this->count === NULL) {
            $beginTime = strtotime(date("Y-m-d"));
            $endTime = $beginTime + 24 * 60 * 60;
            $WordProgressLoginViewL = new WordProgressLoginViewLogic();
            $map['time'] = array(array('egt', $beginTime), array('lt', $endTime));
            $map['student_id'] = $this->id;
            $this->count = $WordProgressLoginViewL->where($map)->count();
        }

        return $this->count;
    }

    /**
     * 学习榜样是否自己
     * @return  boolean 0不是 1是
     */
    public function getHeroIsSelf()
    {
        return $this->heroIsSelf;
    }

    /**
     * 由传入的数据更新当前学生信息
     * @param  array $data 传入数据
     * @return int 更新成功返回ID信息，不成功或未更新返回0
     * @author panjie
     */
    public function update($data)
    {
        $student = array();
        $student['id'] = $this->getId();

        // 对密码进行判断
        if (isset($data['password']) && (trim($data['password']) !== '')) {
            if (!isset($data['newPassword']) || (strlen(trim($data['newPassword'])) < 4)) {
                E("新密码长度小于4");
            } else {
                // 判断原密码是否正确
                if ($this->validatePassword(trim($data['password']))) {
                    // 更新密码
                    $this->changePassword(trim($data['newPassword']));
                } else {
                    E("原密码有误");
                }
            }
        }

        // 写入其它信息.疲劳指数
        if (isset($data['indexOfFatigueId'])) {
            $student['index_of_fatigue_id'] = (int)$data['indexOfFatigueId'];
        }

        // 跟谁比
        if (isset($data['compare'])) {
            $student['compare'] = (int)$data['compare'];
        }

        // 是否成为榜样
        if (isset($data['isHero'])) {
            $student['is_hero'] = (int)$data['isHero'];
        }

        // 附件信息
        if (isset($data['attachmentId'])) {
            $student['image_attachment_id'] = (int)$data['attachmentId'];
        }

        // 姓名
        if (isset($data['name'])) {
            $student['name'] = (string)$data['name'];
        }

        //性别
        if (isset($data['sex'])) {
            $student['sex'] = (int)$data['sex'];
        }

        //学校
        if (isset($data['school'])) {
            $student['school'] = (string)$data['school'];
        }

        return $this->getStudentLogic()->saveList($student);
    }

    /**
     * 判断传入的老密码是否正确
     * @param  string $password 密码
     * @return            bool
     */
    public
    function validatePassword($password)
    {
        $password = StudentLogic::makePassword($password);
        if ($password === $this->password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 更新密码
     * @param  string $password 密码
     * @return bool
     */
    public
    function changePassword($password)
    {
        $data = array();
        $data['password'] = trim($password);
        $data['id'] = $this->id;
        $StudentL = new StudentLogic();
        if ($StudentL->saveList($data) !== FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
