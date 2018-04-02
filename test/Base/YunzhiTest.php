<?php
namespace Base;
use \Think\PhpunitHelper;
use \Think\PhpUnit; // 只有控制器测试类才需要它

abstract class YunzhiTest extends \PHPUnit_Framework_TestCase {
    protected static $app;
    protected static $MVC = array('host' => 'domain.com', 'module' => 'Admin', 'controller' => 'Index');

    static public function setupBeforeClass()
    {
        // 下面四行代码模拟出一个应用实例, 每一行都很关键, 需正确设置参数
        self::$app = new PhpunitHelper();
        self::$app->setMVC(self::$MVC['host'], self::$MVC['module'], self::$MVC['controller']);
        self::$app->setTestConfig(array('DB_NAME'=>'english_study', 'DB_USER'=>'root', 'DB_PWD'=>'', 'DB_HOST'=>'127.0.0.1')); // 一定要设置一个测试用的数据库,避免测试过程破坏生产数据
        self::$app->start();
    }
}
