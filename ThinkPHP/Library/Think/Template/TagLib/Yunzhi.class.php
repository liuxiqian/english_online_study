<?php
namespace Think\Template\TagLib;
use Think\Template\TagLib;
use Think\Page;
/**
 * CX标签库解析类
 */
class Yunzhi extends TagLib {

    // 标签定义
    protected $tags   =  array(
        'page'      =>  array('attr'=>'style, totalCount, class, id', 'close'=>0),
        'test'      =>  array(),
        'access'    =>  array('attr'=>'m, c, a', 'close'=>1),
        'else'      =>  array('close'=>0),
    );

    public function _test($tag, $content)
    {
         $parseStr = "hello" . $content;
         return $parseStr;
    }
    
    /**
     * page标签解析
     * 格式： <html:page id="" class="" totalCount=""/>
     * id
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function _page($tag){
        $id         =   !empty($tag['id']) ? $tag['id'] : '_page';
        $class      =   !empty($tag['class']) ? $tag['class'] : '';
        $totalCount =   !empty($tag['totalcount']) ? '$' . $tag['totalcount'] :
                        (C("YUNZHI_TOTAL_COUNT") ? 'C("YUNZHI_TOTAL_COUNT")' : 0);
        $totalCount = str_replace(':', '->', $totalCount);
        $pageSize   =   C('YUNZHI_PAGE_SIZE') ? 'C("YUNZHI_PAGE_SIZE")' : 20;
        $parseStr   =   "<?php ";
        $parseStr   = 
        $parseStr   .=  '$page = new Think\Page('. $totalCount .',' . $pageSize . ');';

        $parseStr   .=  'echo $page->show();';
        $parseStr   .=  " ?>";
        return  $parseStr;
    }

    /**
     * 进行后台的权限验证
     * 需要MENU类的配合
     * @param  string $tag     
     * @param  string $content 
     * @return 有权限直接输出，无权限则输出空白字符串
     * panjie
     * 2016.05.17     
     */
    public function _access($tag, $content)
    {
        $m = !empty($tag['m']) ? $tag['m'] : MODULE_NAME;
        $c = !empty($tag['c']) ? $tag['c'] : CONTROLLER_NAME;
        $a = !empty($tag['a']) ? $tag['a'] : ACTION_NAME;

        $parseStr = "<?php
                if (\Home\Model\Menu::isMenuAllowedBySessionUser('$m', '$c', '$a')) : 
            ?>";
        $parseStr .= $content;
        $parseStr .= '<?php endif; ?>';
        return $parseStr;
    }
}