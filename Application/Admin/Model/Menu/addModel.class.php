<?php
namespace Admin\Model\Menu;

use MenuPostView\Logic\MenuPostViewLogic;
use Post\Logic\PostLogic;

class addModel
{
    public function getMenuPostListsByMenuId($menuId)
    {
        try
        {
            static $posts = null;
            if ($posts !== null)
            {
                return $posts;
            }

            //取岗位信息
            $PostL = new PostLogic();
            $posts = $PostL->select();
            
            //取 菜单 岗位 联合信息
            $MenuPostViewL = new MenuPostViewLogic();
            $map = array();
            $map = array("menu_id" => $menuId);
            $datas = $MenuPostViewL->where($map)->select();
            $datas = change_key($datas, "post_id");

            //依次查找岗位，添加权限信息
            foreach($posts as $key => $post)
            {
                $posts[$key]['is_permission'] = $datas[$post['id']]['is_permission'] === null ? 0 : 1;
            }
            
            return $posts;
        }
        catch(\Think\Exception $e)
        {
            echo "Data connect error:" . $e->getMessage();
            return false;   
        }
        
        
    }
}