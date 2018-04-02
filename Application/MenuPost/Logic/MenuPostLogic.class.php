<?php
namespace MenuPost\Logic;

use MenuPost\Model\MenuPostModel;

class MenuPostLogic extends MenuPostModel
{
    /**
     * 保存新的 菜单 岗位 是否有权限信息
     * @param  lists $postIds 岗位ID
     * @param  int $menuId  菜单id
     * @return           
     */
    public function saveListsByPostIdsMenuId($postIds, $menuId)
    {
        $map = array();
        $map['menu_id'] = (int)$menuId;

        try
        {
            $this->where($map)->delete();

            $data = $map;
            foreach($postIds as $postId)
            {
                $data['post_id'] = $postId;
                $this->saveList($data);
            }
        }
        catch(\Think\Exception $e)
        {
            $this->setError("Date delete error: " . $e->getMessage());
            return false;
        }
    }
    // public function saveAll($datas)
    // {
    //     foreach ($datas as $data) {
    //         $list['menu_id'] = $data['id'];
    //         $list['post_id'] = 1;
    //         $list['is_permission'] = 1;
    //         $this->add($list);
    //         // dump($list);
    //         // exit();
    //     }
    // }
}