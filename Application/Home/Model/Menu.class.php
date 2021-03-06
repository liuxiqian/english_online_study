<?php

namespace Home\Model;

use Menu\Logic\MenuLogic;           // 菜单表
use UserMenuView\Logic\UserMenuViewLogic;   // 用户菜单视图
use Admin\Model\User;

/**
 * 菜单
 */
class Menu extends Model
{
        static protected $MenuL = NULL;                    // id
static private $allLists = NULL;
    public $data = ['_class' => __CLASS__];
    private $sonMenus = array();         // 是否当前菜单
    private $userMenuLists = NULL;

    public function __construct($dataOrData = NULL)
    {
        if (!is_null($dataOrData)) {
            if (is_array($dataOrData)) {
                $this->setData($dataOrData);

            } else {
                $menu = $this->getMenuL()->where("id=$dataOrData")->find();
                if ($menu === NULL) {
                    E("读取菜单" . $dataOrData . "发生错误" . $this->getMenuL()->getError());
                }
                $this->setData($menu);
            }
        }
    }

    public static function getMenuL()
    {
        if (is_null(self::$MenuL)) {
            self::$MenuL = new MenuLogic;
        }

        return self::$MenuL;
    }

    /**
     * @return array
     * Create by panjie@yunzhiclub.com
     * 获取所有的前台菜单
     */
    static public function getAllLists()
    {
        if (is_null(self::$allLists)) {
            $cacheKey = '';
            self::$allLists = [];
            if (FALSE === Cache::get(__CLASS__, __FUNCTION__, $cacheKey)) {
                $MenuL = new MenuLogic();
                self::$allLists = $MenuL->getListByIsDev("Home");
                foreach (self::$allLists as &$list) {
                    $list = new self($list);
                }
                Cache::set(__CLASS__, __FUNCTION__, $cacheKey, self::$allLists);
                unset($MenuL);

            } else {
                self::$allLists = Cache::get(__CLASS__, __FUNCTION__, $cacheKey);
            }
        }

        return self::$allLists;
    }

    /**
     * 根据M C A的值，来判断当前SESSION用户是否对此菜单拥有权限
     * @param  string $module moudle
     * @param  string $controller controller
     * @param  string $action action
     * @return boolean 0无权限 ； 1有权限.
     */
    static function isMenuAllowedBySessionUser($module, $controller, $action)
    {
        // 取当前用户信息
        $User = session("User");
        if (is_null($User)) {
            return 0;
        }

        $cacheKey = $module . '_' . $controller . '_' . $action . '_' . $User->getId();
        $access = Cache::get(__CLASS__,
            __FUNCTION__,
            $cacheKey);

        if (FALSE === $access) {
            // 取用户对应的菜单列表信息
            $menuCacheKey = 'UserMenus';
            $UserMenus = Cache::getSon(__CLASS__, __FUNCTION__, $menuCacheKey, $User->getId());

            if (FALSE === $UserMenus) {
                $Menu = new Menu;
                $UserMenuModels = $Menu->getUserMenuLists($User);
                $UserMenus = [];
                foreach ($UserMenuModels as $UserMenu) {
                    array_push($UserMenus,
                        [
                            'module'     => $UserMenu->getModule(),
                            'controller' => $UserMenu->getController(),
                            'action'     => $UserMenu->getAction(),
                            'is_dev'     => $UserMenu->getIsDev(),
                        ]);
                }
                Cache::setSon(__CLASS__, __FUNCTION__, $menuCacheKey, $User->getId(), $UserMenus);
                unset($Menu);
            }

            // 查看用户是否拥有权限
            foreach ($UserMenus as $Menu) {
                if (strtolower($Menu['module']) == strtolower($module)) {
                    if (strtolower($Menu['controller']) == strtolower($controller)) {
                        if (strtolower($Menu['action']) == strtolower($action)) {
                            if (APP_DEBUG) {
                                $access = 1;
                                Cache::set(__CLASS__,
                                    __FUNCTION__,
                                    $cacheKey, $access);

                                return $access;
                            } else if (!$Menu['is_dev']) {
                                $access = 1;
                                Cache::set(__CLASS__,
                                    __FUNCTION__,
                                    $cacheKey, $access);

                                return $access;
                            }
                        }
                    }
                }
            }

            $access = 0;
            Cache::set(__CLASS__,
                __FUNCTION__,
                $cacheKey, $access);
        }

        return $access;
    }

    /**
     * 获取某用户的菜单列表
     * @param  User $User 用户
     * @return array   Menu
     * panjie
     */
    public function getUserMenuLists(User $User)
    {
        if (NULL !== $this->userMenuLists) {
            return $this->userMenuLists;
        } else {
            // 根据当前用户id取用户权限menu列表
            $maps = array("id" => $User->getId());
            $UserMenuViewL = new UserMenuViewLogic;
            $userMenuLists = $UserMenuViewL->where($maps)->select();
            foreach ($userMenuLists as $menuList) {
                try {
                    $Menu = new Menu($menuList['menu_id']);
                    $this->userMenuLists[] = $Menu;
                } catch (\Think\Exception $e) {
                    // 有时候，删除数据的时候，没有关联删除，结果吧，数据就产生冗余了。然后吧，NEW MENU的时候，就报错了。
                }
            }
            unset($UserMenuViewL);

            return $this->userMenuLists;
        }
    }

    /**
     * 获取某个学生的菜单列表信息
     * @param  Student $Student 学生
     * @return array(菜单)
     */
    public function getAllListsByStudent(Student $Student)
    {
        static $studentId = 0;
        static $Menus = array();
        if ($studentId != $Student->getId()) {

        }

        return $Menus;

    }

    /**
     * 判断是否为激活菜单
     * @return boolean
     */
    public function getIsActive()
    {
        if ($this->getIsCurrent()) {
            return TRUE;
        }

        // 不是空数组，则继续进行判断，为空数组，则返回false
        if ($SonMenus = $this->getSonMenus()) {
            foreach ($SonMenus as $SonMenu) {
                return $SonMenu->getIsActive();
            }
        }

        return FALSE;
    }

    /**
     * 判断是否为当前菜单
     * @return boolean
     */
    public function getIsCurrent()
    {
        if (!strcasecmp($this->controller, CONTROLLER_NAME) && !strcasecmp($this->action, ACTION_NAME)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 获取 子菜单
     * @return lists
     */
    public function getSonMenus()
    {
        $isShow = NULL;

        return $this->_getSonMenus($isShow);
    }

    /**
     * 获取 子菜单
     * @param  integer $isShow 1:只获取可见子菜单 其它:获取全部子菜单
     * @return lists
     */
    public function _getSonMenus($isShow = 1)
    {
        $map = array();
        if ($isShow === 1) {
            $map['isShow'] = "1";
        }

        $map['parent_id'] = $this->id;

        // 判断是否开发模式
        if (!APP_DEBUG) {
            $map['is_dev'] = '0';
        }

        $menus = $this->getMenuL()->where($map)->select();
        if (count($menus) === 0) {
            return FALSE;
        }

        $result = array();
        foreach ($menus as $menu) {
            $result[] = new Menu($menu['id']);
        }

        return $result;
    }

    /**
     * 取可见的子菜单（去除一些不可见菜单）
     * @return lists
     */
    public function getShowSonMenus()
    {
        $isShow = 1;

        return $this->_getSonMenus($isShow);
    }

    public function getMenuLists($module = "Admin")
    {

        if ($this->menus !== NULL) {
            return $this->menus;
        }

        $this->menus = $this->getMenuL()->getListByIsDev($module);

        //比较菜单列表和用户权限列表
        //去掉用户没有权限的menu列表
        foreach ($this->menus as $key => $menu) {
            if (($this->_checkMenu($menu['id'], $this->getUserMenuLists())) === FALSE) {
                unset($this->menus[$key]);
            }
        }

        return $this->menus;
    }

    /**
     * 检测MENUID 是否存在于目录树中
     * @param  int $menuId 菜单ID
     * @param  tree $menuTrees 目录树
     * @return 存在返回true            不存在返回false
     */
    private function _checkMenu($menuId, $menuTrees)
    {
        $menuId = (int)$menuId;
        foreach ($menuTrees as $menuTree) {
            if ((int)$menuTree['menu_id'] === $menuId) {
                return TRUE;
            } else if (is_array($menuTree['_son'])) {
                return $this->_checkMenu($menuId, $menuTree['_son']);
            }
        }

        return FALSE;
    }

    /**
     * 获取未读的消息数
     * @param  Student &$Student 学生
     * @return int
     */
    public function getUnReadMessageCount(Student &$Student)
    {
        if ('Notes' === $this->getController()) {
            return NotesStudent::getReadedNotesCount($Student);
        }

        return 0;
    }

    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param  [array] $where查询条件
     * @param  [int] $layer 查询层级
     * @param  integer 用于返回第几层
     * @return [type] 带有数据信息的数组
     */
    private function _getMenuList($where, $layer)
    {
        $menuList = $this->where($where)->order(array('order' => 'desc', 'id' => "desc"))->select();
        //如果结果为空,则返回false
        if ($menuList == NULL)
            return FALSE;

        //判断层级
        if ($layer--) {
            foreach ($menuList as $key => $value) {
                $map = $where;
                $map['parent_id'] = $value['id'];
                $son = $this->_getMenuList($map, $layer);
                if ($son !== FALSE) {
                    $menuList[$key]['_son'] = $son;
                }
            }
        }

        return $menuList;
    }
}