<?php
namespace Home\Controller;

use Home\Model\Test;        // 测试
use Home\Model\SelfTest;    // 单元测试
use Test\Model\TestModel;   // 测试
use Home\Model\NewWord;     // 生词
/**
 * 学生测试
 */
class TestController extends HomeController
{
    public function indexAction()
    {   
        $type = I('get.type');

        // 随堂测试
        if (I('get.id') !== '')
        {
            $Test = new Test(I('get.id'));

            // 判断用户是否有测试权限
            if (!$Test->isAccess($this->Student))
            {
                echo "Access denied!";
            }
        }
        
        // 自我测试
        else if ($type !== '')
        {   
            $Test = new SelfTest($this->Student, $type);

            // 判断是否有测试权限
            if (!$Test->getIsAllow($this->Student))
            {
                echo "Access denied!";
            }
        }

        // 报错
        else
        {
            echo "param error";
            return;
        }

        $this->assign("Test", $Test);
        $this->display();
    }

    /**
     * 学生交卷
     * @return result 成功status:SUCCESS, 失败status:ERROR,message:失败信息
     * @author  panjie <3792535@qq.com>
     */
    public function handPaperAjaxAction()
    {
        $data['test_percent_id'] = I('get.id');
        $data['grade'] = I('get.grade');
        $data['student_id'] = $this->Student->getId();

        // 将答错的题，加入生词本
        $post = json_decode(file_get_contents('php://input'), true);
        $wordIds = $post['data']['wrongs'];
        if (is_array($wordIds))
        {
            foreach ($wordIds as $wordId)
            {
                $wordId = (int)$wordId;
                $NewWord =  new NewWord($wordId);
                if ($NewWord->getId() != 0)
                {
                    $NewWord->add($this->Student);
                }
            }
        }

        // 返回结果
        $result = array();
        $result['status'] = 'SUCCESS';
        $TestM = new TestModel();
        if ($TestM->create($data))
        {
            $TestM->add();
        }
        else
        {
            $result['status'] = "ERROR";
            $result['message'] = "数据写入失败，原因:" . $TestM->getError();
        }

        $this->ajaxReturn($result);
    }
}
