<?php
namespace Home\Controller;

use Admin\Controller\MenuController as MenuC;

class MenuController
{
    public function addAction()
    {
        // dump($_SERVER);
        header('Location: ' . __ROOT__ . '/admin.php/' . I('server.PATH_INFO'));
    }
}