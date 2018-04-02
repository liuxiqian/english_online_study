<?php
/**
 * 单词
 */
namespace Word\Logic;

use Word\Model\WordModel;
use Course\Logic\CourseLogic;   //课程

class WordLogic extends WordModel
{
    static private $WordLogic = null;
    static public function getCurrentWordLogic() {
        if (is_null(self::$WordLogic)) {
            self::$WordLogic = new self();
        }

        return self::$WordLogic;
    }
}