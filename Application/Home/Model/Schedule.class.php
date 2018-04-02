<?php
/**
 * 学习进度详情
 * User: panjie
 * Date: 17/6/12
 * Time: 下午2:16
 */

namespace Home\Model;


use WordProgressLoginWordCourseView\Logic\WordProgressLoginWordCourseViewLogic;

class Schedule extends Model
{
    protected $totalMinutes;
    protected $lastTotalMinutes;
    protected $newStudyWordCount;
    protected $oldStudyWordCount;
    protected $courseTotalWordCount;

    public function __construct($data)
    {
        parent::__construct();
        $this->data = $data;
    }

    public static function getListsByStudentId($studentId)
    {
        $map = [];
        $map['login__student_id'] = $studentId;
        $lists = WordProgressLoginWordCourseViewLogic::getCurrentObject()->where($map)->select();
        $results = [];
        foreach ($lists as $list) {
            $courseId = $list['word__course_id'];
            if (!array_key_exists($courseId, $results)) {
                $results[$courseId] = [];
                $results[$courseId]['lists'] = [];
                $results[$courseId]['loginTimes'] = [];
                $results[$courseId]['course_id'] = $list['word__course_id'];
                $results[$courseId]['course_title'] = $list['course__title'];
                $results[$courseId]['first_study_time'] = $list['time'];
                $results[$courseId]['last_study_time'] = '0';
                $results[$courseId]['new_study_count'] = 0; // 新学数
            }

            // 首次学习时间
            if ($results[$courseId]['first_study_time'] > $list['time']) {
                $results[$courseId]['first_study_time'] = $list['time'];
            }

            // 更新最后学习时间
            if ($results[$courseId]['last_study_time'] < $list['time']) {
                $results[$courseId]['last_study_time'] = $list['time'];
            }

            // 学习次数
            if (!in_array($list['login__time'], $results[$courseId]['loginTimes'])) {
                array_push($results[$courseId]['loginTimes'], $list['login__time']);
            }

            // 学习新单词数
            // 更新最后学习时间
            if ($results[$courseId]['new_study_count'] < (int)$list['word__index']) {
                $results[$courseId]['new_study_count'] = (int)$list['word__index'];
            }

            array_push($results[$courseId]['lists'], $list);
        }

        $schedules = [];
        foreach ($results as $result) {
            $schedule = new self($result);
            array_push($schedules, $schedule);
        }

        return $schedules;
    }

    public function getStudyCount()
    {
        return count($this->data['loginTimes']);
    }

    public function getLastTotalMinutes() {
        if (is_null($this->lastTotalMinutes)) {
            // 取上次学习的所有记录，并记算用时
            $loginTime = array_values(array_slice($this->data['loginTimes'], -1))[0];
            $words = [];
            foreach ($this->data['lists'] as $list) {
                if ($list['login__time'] === $loginTime) {
                    array_push($words, $list);
                }
            }
            $this->lastTotalMinutes = StudyRecord::getEffectiveMinutesByWords($words);
        }

        return $this->lastTotalMinutes;
    }

    public function getTotalMinutes() {
        if (is_null($this->totalMinutes)) {
            $this->totalMinutes = StudyRecord::getEffectiveMinutesByWords($this->data['lists']);
        }
        return $this->totalMinutes;
    }

    public function getNewStudyWordCount() {
        return $this->data['new_study_count'];
    }

    public function getOldStudyWordCount() {
        return $this->getTotalStudyWordCount() - $this->getNewStudyWordCount();
    }

    public function getTotalStudyWordCount() {
        return count($this->data['lists']);
    }

    public function getCourseTotalWordCount() {
        if (is_null($this->courseTotalWordCount)) {
            $this->courseTotalWordCount = Course::getWordCountById($this->data['course_id']);
        }
        return $this->courseTotalWordCount;
    }

    public function getRemainWordCount() {
        return $this->getCourseTotalWordCount() - $this->getNewStudyWordCount();
    }

    public function getStudyProcess() {
        return (int)($this->getNewStudyWordCount() * 100 / $this->getCourseTotalWordCount());
    }

}