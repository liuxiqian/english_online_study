<?php
namespace Home\Controller;

header("content-type:text/html;charset=utf-8");

class TestWjyController
{
    public function indexAction()
    {
        $Student = new \Home\Model\Student();
        $Statistics = new \Home\Model\Statistics($Student);
        $M = new \Home\Model\DayStudyCount();
        dump($M);
    }  
}