<?php
namespace Home\Model;

use Login\Logic\LoginLogic;     // 登陆
use Login\Model\LoginModel;
use WordProgress\Model\WordProgressModel; // 学习记录
/**
 * 登陆信息
 */
class Login
{
    private $id = 0;
    private $time = 0;
    private $studentId = 0;

    public function __construct($id = 0)
    {
        $id = (int)$id;
        $LoginM = new LoginModel;
        $login = $LoginM->where('id=' . $id)->find();
        if (null !== $login)
        {
            $this->id = $id;
            $this->time = (int)$login['time'];
            $this->studentId = (int)$login['student_id'];
        }
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function getTime()
    {
        return (int)$this->time;
    }

    public function getStduentId()
    {
        return (int)$this->studentId;
    }

    public function getStudent()
    {
        if (null === $this->Student)
        {
            $this->Student = new Student($this->getStudentId());
        }

        return $this->Student;
    }

    /**
     * 获取新学单词个数
     * @return int 
     * @author panjie <panjie@yunzhi.club>
     */
    public function getStudiedNewWordsCount()
    {
        return 0;
        if (null === $this->studiedNewWordsCount)
        {
            $this->studiedNewWordsCount = $this->_getStudiedWordsCountByIsNew(1);
        }

        return $this->studiedNewWordsCount;
    }

    /**
     * 获取复习单词的个数
     * @return int 
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getReviewedWordCount()
    {
        if (null === $this->reviewedWordCount)
        {
            $this->reviewedWordCount = $this->_getStudiedWordsCountByIsNew(0);
        }

        return $this->reviewedWordCount;
    }

    /**
     * 获取新学单词 或 复习单词 的数量
     * @param  int    $isNew 1:新学;0:复习
     * @return int        
     * @author panjie <panjie@yunzhiclub.com>
     */
    private function _getStudiedWordsCountByIsNew(int $isNew)
    {
        $WordProgessM = new WordProgressModel;
        $map = array();
        $map['is_new'] = $isNew;
        $map['login_id'] = $this->getId();
        $count = $WordProgessM->where($map)->count();
        unset($WordProgessM);
        return $count;
    }

    /**
     * 获取学习分钟数
     * @return int 
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getStudyMinites()
    {
        return 0;
        if (null === $this->studyMinites)
        {
            $this->studyMinites = floor($this->getStudySeconds()/60 + 0.5);
        }

        return $this->studyMinites;
    }

    /**
     * 获取学习秒数
     * @return int 
     * @author panjie panjie@yunzhiclub.com
     */
    public function getStudySeconds()
    {
        if (null === $this->studySeconds)
        {
            $this->studySeconds = 0;

            // 取出所有的记录
            $map = array();
            $map['login_id'] = $this->getId();

            $WordProgessM = new WordProgressModel;
            $lists = $WordProgessM->where($map)->order('id asc')->select();

            // 取差，符合范围，累加
            $preTime = 0;
            foreach ($lists as &$list)
            {
                if ($list['time'] - $preTime <= C('YUNZHI_TIME_INTERVAL'))
                {
                    $this->studySeconds += $list['time'] - $preTime;
                }

                $preTime = $list['time'];
            }
        }

        return $this->studySeconds;
    }

    /**
     * 获取最后一次有学习记录登陆记录
     * @return LoginRecored 
     * @author panjie <panjie@yunzhiclub.com>
     */
    static public function getLastStudiedRecord(Student &$Student)
    {
        // 取出当前登陆记录
        $currentLogin = self::getCurrentLogin($Student);
        return $currentLogin;
        // 按时间顺序取出所有的在当前登陆记录以前的登陆记录
        $map = array();
        //$map['id'] = array('lt', $currentLogin->getId());
        //
        //$LoginM = new LoginModel;
        //$logins = $LoginM->field('id')->where($map)->order('id desc')->select();

        //$map['id'] = $currentLogin->getId()

        // 依次查找是否有学习记录, 有则返回
        $WordProgessM = new WordProgressModel;
        foreach ($logins as $login)
        {
            $map = array();
            $map['login_id'] = $login['id'];
            if ($WordProgessM->where($map)->count())
            {
                return new Login($login['id']);
            }
        }

        // 返回默认记录
        return new Login(0);
    }

    /**
     * 获取当前登陆信息
     * @param  Student $Student 学生
     * @return Login           
     */
    static public function getCurrentLogin(Student $Student)
    {
        $LoginL = new LoginLogic();
        $map = array();
        $map['student_id'] = $Student->getId();
        $login = $LoginL->where($map)->order("id desc")->find();
        return new Login($login['id']);
    }

    /**
     * 用户登陆
     * @param Student $Student 学生
     */
    static public function Login(Student &$Student)
    {
        $data = array();
        $data['student_id'] = $Student->getId();
        $LoginL = new LoginLogic();
        $LoginL->saveList($data);
        unset($LoginL);
        return;
    }

    /**
     * 获取学生所有的登陆信息
     * @param  Student $Student 
     * @return array Login
     * @author panjie <3792535@qq.com>
     */
    static public function getLogins(Student $Student)
    {
        $LoginL = new LoginLogic;
        $map = array();
        $map['student_id'] = $Student->getId();
        $lists = $LoginL->field('id')->where($map)->order("id desc")->select();
        $result = array();
        foreach ($lists as $list)
        {
            $result[] = new Login($list['id']);
        }
        return $result;
    }
}