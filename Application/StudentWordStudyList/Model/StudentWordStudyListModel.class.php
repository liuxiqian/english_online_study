<?php
namespace StudentWordStudyList\Model;
use Think\Model;
use Home\Model\Word;
use Home\Model\Student;

/**
 * 学生单词学习记录.记录学生在学习过程中需要重复学习的单词及时点
 */
class StudentWordStudyListModel extends Model
{
    protected static $T = 900;                      // 最大的暂离有效时间。大于该时间视为用户为首次学习该单词
    protected static $D1 = 60;                        // 首次出现，用户点击认识, indexl置为2, D1后再出现
    protected static $D2 = 60;                        // 用户点击不认识后，index置为0, D2后再出现
    protected static $D3 = 120;                       // 单词在D2时间后出现，点击认识，index置为1，D3后再出现
    protected static $D4 = 160;                       // 单词在D3时间后出现，点击认识，index置为2, D4后再出现

    protected $pk = ['student_id', 'word_id'];      // 主键
    /**
     * 判断单词是否首次出现
     * @param    Word                     &$Word    单词
     * @param    Student                  &$Student 学生
     * @return   boolean                            
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-08T16:30:06+0800
     */
    public function isFirstTimeShow(Word &$Word, Student &$Student)
    {
        if ((0 === $Word->getId()) || (0 === $Student->getId())) {
            return false;
        } else {
            $map = array();
            $map['word_id'] = $Word->getId();
            $map['student_id'] = $Student->getId();
            $list = $this->where($map)->find();
            if (null === $list) {
                return ture;
            } else {
                return false;
            }
        }
    }

    /**
     * 获取现在需要学习的单词，不存在则返回默认单词
     * @param    Student                  &$Student 学生
     * @return   Word                             单词
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-08T16:40:53+0800
     */
    public function getNowStudyWord(Student &$Student)
    {
        if (0 === $Student->getId()) {
            return false;
        } else {
            $map = array();
            $map['student_id'] = $Student->getId();
            $map['time'] = array('lt', time());
            $list = $this->where($map)->order('time asc')->find();

            if ($list) {
                return new Word($list['word_id']);
            } else {
                return new Word(0);
            }
        }
    }

    /**
     * 计算并设置单词的下一次出现的时间
     * @param    Word                     &$Word    单词
     * @param    Student                  &$Student 学生
     * @param    string                   $type     认识：know, 不认识或认错：unknow
     * @return   null                             
     * @author panjie panjie@mengyunzhi.com
     * @DateTime 2016-10-10T16:46:35+0800
     */
    public function computeAndSetNextAppearTime(Word &$Word, Student &$Student, $type)
    {        
        $data               = [];
        $data['student_id'] = $Student->getId();
        $data['word_id']    = $Word->getId(); 

        // 首次出现, 执行添加操作
        if ($this->isFirstTimeShow($Word, $Student)) {
            // 认识, index置为2，时间加D1
            if ('know' === $type) {
                $data['index']      = 2;
                $data['time']       = time() + $this::$D1;
                
            // 不认识, index置为0，时间加D2
            } else {
                $data['index'] = 0;
                $data['time']   = time() + $this::$D2;
            }
            
            // 将最新的数据加入
            $this->data($data)->add();
        // 非首次出现, 执行先删除后更新操作
        } else {
            // 先取出记录置数据，再删除删除原有记录
            $map = [];
            $map['student_id'] = $Student->getId();
            $map['word_id'] = $Word->getId();
            $data = $this->where($map)->find();
            $index = (int)$data['index'];
            $data['repeat_times']++;

            // 认识
            if ('know' === $type) {

                // 和上一次的学习时间间隔超出了暂离时间, 则index置0
                if (time() - (int)$data['time'] > $this::$T) {
                    $data['index'] = 0;
                    $data['time'] = time() + $this::$D1;

                // 间隔时间未超出暂离时间，则按算法计算
                } else {
                    // index为0，1，则index+1, 增加D3或D4
                    if ($index < 2) {
                        if ($index === 0) {
                            $data['time'] = time() + $this::$D3;
                        } else {
                            $data['time'] = time() + $this::$D4;
                        }

                    // index非0，1（即：2），则直接删除该条记录后返回
                    } else {
                        $this->where($map)->delete();
                        return;
                    }
                    $data['index'] = ++$index;
                }
                
            // 不认识, index置为0，时间加D2
            } else {
                $data['index'] = 0;
                $data['time'] = time() + $this::$D2;
            }

            // 更新时间
            $this->where($map)->data($data)->save();
        }

        return;
    }
}
