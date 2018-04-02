<?php
/**
 * thinkphp3.2 单元测试
 * https://github.com/snowair/think-phpunit
 */
namespace Home\Model;
use Base\YunzhiTest;
use User\Model\UserModel;

class UserModelTest extends YunzhiTest
{
    public function test() {
        $userModel = new UserModel();
        $users = $userModel->select();
        var_dump($users); // 这里只是做测试演示。生产环境下，请勿使用打印功能，以免控制台由于日志信息过多引发的错误。
        $this->assertEquals('admin', 'admin');
    }
}