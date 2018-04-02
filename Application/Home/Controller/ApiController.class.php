<?php
namespace Home\Controller;

use Home\Model\Course;                 // 教师

class ApiController extends HomeController
{
    public function getLinkLookWordsAjaxAction()
    {
        $count = I("get.count");

        $CourseM = new Course(8);
        $words = $CourseM->getRandomStarWords($count);
        // dump($words);

        foreach ($words as $key => $word) {
            $randomWords[2*$key]['id'] = $word->getId();
            $randomWords[2*$key]['name'] = $word->getTitle();

            $randomWords[2*$key+1]['id'] = $randomWords[2*$key]['id'];
            $randomWords[2*$key+1]['name'] = $word->getTranslation();
        }

        shuffle($randomWords);
        // dump($randomWords);
        
        $this->ajaxReturn($randomWords);
    }
}
