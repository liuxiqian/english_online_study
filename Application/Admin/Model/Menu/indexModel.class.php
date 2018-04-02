<?php
namespace Admin\Model\Menu;
use Menu\Logic\MenuLogic;

class indexModel
{
    public function getModules()
    {
        $MenuL = new MenuLogic();
        $datas = $MenuL->distinct(true)->field('module')->select();
        unset($MenuL);
        return $datas;
    }
}