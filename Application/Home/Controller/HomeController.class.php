<?php
namespace Home\Controller;

use Think\Controller;
use Home\Model\Student;                 // 学生
use Home\Model\Menu;                    // 菜单

class HomeController extends Controller
{
    protected $Student = null; // 学生
    public function __construct()
    {   
        $this->Student = Student::getLoginStudent();
        if ((true === $this->Student->getIsDefault()) || (0 !== (int)$this->Student->getStatus()))
        {
            Student::logOut();
            $this->redirect('Login/index',0);
        }
        //
        parent::__construct();
        $Menus = Menu::getAllLists();

        // 取菜单数据
        $this->assign("Menus", $Menus);
        $this->assign("Student", $this->Student);
    }

    public function _empty()
    {
        echo "404 page Not found!";
    }
}