<?php
namespace Yunzhi\Model;

use Think\Model;

class YunzhiModel extends Model
{
    private $lists = array();                           // 数据列表

    protected $p                = 1;                    // 当前页
    protected $pageSize         = 20;                   // 每页多少条记录
    protected $totalCount       = 0;                    // 总条数
    protected $orderBys         = array("id"=>"desc");  // 排序字段方式
    protected $maps             = array();              // 查询条件
    protected $keywords         = "";                   // 查询关键字
    protected $field            = "title";              // 查询字段
    protected $backFields       = array();              // 回显字段
    protected $pk               = "id";                 // 主键
    protected $fk               = "";                   // 外键
    protected $relationals      = array();              // 关联删除模型
    protected $dependencies     = array();              // 依赖删除模型

    public function __construct()
    {
        $this->p        = (int)I('get.p') ? (int)I('get.p') : 1;
        $this->pageSize =   (I("get.pagesize") !== "") ? I("get.pagesize") : 
                            (C("YUNZHI_PAGE_SIZE") ? C("YUNZHI_PAGE_SIZE") : 20);

        $this->keywords = trim(I('get.keywords'));
        $this->field    = (I('get.field') === "" || (int)I('get.field')) ? $this->field : I('get.field');

        if (trim(I('get.filed')) !== "")
        {
            $filed = trim(I('get.field'));
        }

        if($this->keywords !== "")
        {
            $this->maps[$this->field] = array("like", "%" . $this->keywords . "%");
        }
        
        if (I("get.by") !== "")
        {
            $by = I("get.by");
            $order = I("get.order");
            $this->setOrderBys(array($by=>$order));
        }
        else if(I("get.order") !== "")
        {
            $by = "id";
            $order = I("get.order");
            $this->setOrderBys(array("$by"=>$order));
        }
        
        parent::__construct();
        $this->_makeFk();       // 自动生成外键
    }

    public function setP($p)
    {
        $this->p = (int)$p;
        return $this;
    }

    public function getP()
    {
        return $this->p;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = (int)$pageSize;
        return $this;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setTotalCount($totalCount)
    {
        $this->totalCount = (int)$totalCount;
        return $this;
    }

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function addOrderBy($by, $order)
    {
        $order = ($order == "desc") ? "desc" : "asc";
        $this->orderBys["$by"] = $order;
        return $this;
    }

    public function subOrderBy($by)
    {
        unset($this->orderBys["$by"]);
        return $this;
    }

    public function setOrderBys($orderBys)
    {
        if(!is_array($orderBys))
        {
            $this->setError("orderbys must be array");
            return false;
        }
        $this->orderBys = $orderBys;
        return $this;
    }

    public function setBackFields($backFields)
    {
        $this->backFields = $backFields;
        return $this;
    }

    public function getBackFields()
    {
        return $this->backFileds;
    }

    public function addBackFields($value)
    {
        $this->backFields[] = $value;
        return $this;
    }

    public function subBackFileds($value)
    {
        foreach($this->backFields as $k => $v)
        {
            if($value == $v)
            {
                unset($this->backFields["$k"]);
            }
        }
    }


    /**
     * 如果未传入第二个参数，则第一个参数必须为数组，进行合并。
     * @param [type] $map   [description]
     * @param [type] $value [description]
     */
    public function addMaps($map, $value = null)
    {
        if($value === null)
        {
            if(!is_array($map))
            {
               $this->setError("The 'map' param must be the array type of key value.");
               return $this;
            }
            $this->maps = array_merge($this->maps , $map);
        }
        else
        {
            $this->maps["$map"] = $value;  
        }
        
        return $this;
    }

    public function subMaps($key)
    {
        unset($this->maps["$key"]);
        return $this;
    }

    public function setMaps($maps)
    {
        if(!is_array($maps))
        {
            $this->setError("Type of maps not array");
            return $this;
        }
        $this->maps = $maps;
        return $this;
    }

    public function getMaps()
    {
        return $this->maps;
    }

    /**
     * 更新数据表（有ID则更新，无则添加）
     * @param  array $list 一维数据
     * @return int       数据关键字
     */
    public function saveList($list){
        try{
            if ($this->create($list))
            {
                if (isset($this->data[$this->pk]) && $this->data[$this->pk] !== '')
                {
                    $this->save();
                    return $list[$this->pk];
                }
                else
                {
                    return $this->add();
                }
            }
            else
            {
                $this->setError("data create false:" . $this->getError());
                return false;
            }
        }
        catch (\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }

    /**
     * link of deleteList($id)
     */
    public function deleteListById($id)
    {
        return $this->deleteList($id);
    }

    /**
     * 删除ID为$id的数据
     * @param  int $id 
     * @return 返回成功删除的个数
     */
    public function deleteList($id)
    {
        $map[$this->pk] = (int)$id;
        try
        {
            return $this->where($map)->delete();
        }
        catch(\Think\Exception $e)
        {
            $this->setError("Data connect error: " . $e->getMessage());
            return false;
        }
        
    }

    /**
     * 获取获取数据信息
     * panjie
     * update:2016.04
     * 返回值由false改为null
     */

    public function getListbyId($id)
    {
        $id = (int)$id;
        if ($id === 0)
        {
            $this->setError('$id can not be zero');
            return null;
        }
        try
        {
            $pk = $this->pk;
            $maps = $this->maps;
            $maps["$pk"] = $id;
            $list = $this->where($maps)->find();
            return $list;
        }
        catch(\Think\Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }
    }
    /**
     * 获取当前页内容列表
     */

    public function getLists($backFields = array(), $maps = array())
    {
        $temp   = $this->_getLists($backFields, $maps);
        $page   = $this->p . "," . $this->pageSize;
        $lists  = $temp->         
                    page("$page")->
                    select();
                    
        //利用C函数，向PAGE标签传值
        C("YUNZHI_TOTAL_COUNT", $this->totalCount);
        C("YUNZHI_PAGE_SIZE", $this->pageSize);
        C("YUNZHI_P", $this->p);
        return $lists;
    }

    /**
     * 获取所有数据
     * @param  array  $fields 回显字段
     * @param  array  $maps   附加查询条件
     * @return [type]         [description]
     */
    public function getAllLists($backFields = array(), $maps = array())
    {
        $lists =    $this->
                    _getLists($backFields, $maps, 1)->
                    order($this->orderBys)->
                    select();
        return $lists;
    }

    /**
     * 
     * @param   $isShowAll 是否为返回全部的记录 返回全部记录，则不排序。
     * 
     * */
    private function _getLists($backFields = array(), $maps = array(), $isShowAll = 0)
    {
        if (!is_array($backFields) || !is_array($maps))
        {
            $this->setError("type of params incorect");
            return $this;
        }

        //合并回显字段与查询条件
        $backFields = array_merge($this->backFields, $backFields);
        $maps = array_merge($this->maps, $maps);
        $this->_getCounts($maps);
        if ($isShowAll)
        {      
            return $this->
                field($backFields)->
                where($maps);
        }
        else
        {
            return  $this->
                field($backFields)->
                where($maps)->
                order($this->orderBys);
        }
    }


    //重新计算当前页码及总数
    private function _getCounts($maps)
    {
        $this->totalCount = $this->where($maps)->count();
        $this->p = ((int)ceil($this->totalCount / $this->pageSize) < $this->p) ?
                    (int)ceil($this->totalCount / $this->pageSize) :
                    $this->p;
    }


    /**
     * 重写删除
     * @param    $options 
     * @return           
     */
    public function delete($options = array())
    {
        // 预删除
        if ( $this->prepareDelete($options) === false)
        {
            return false;
        }
        $map = array();
        foreach ($this->lists as $list)
        {
            $map[$this->fk] = $list[$this->pk];

            // 删除关联表
            foreach ($this->relationals as $relational)
            {
                // 检测类型
                $this->_checkIsObject($relational);
                $relational->where($map)->delete();
            }
        }
        return parent::delete($options);
    }

    /**
     * 预删除
     * @param  array $options 
     * @return bool          
     */
    public function prepareDelete(&$options = array())
    {
        // 计算选项信息，判断删除条件是否为空
        $options = $this->_parseOptions($options);   
        if(empty($options['where'])){                  
            $this->setError("where is empty");
            return false;
        }
        
        // 查询预删除数据
        $this->lists = $this->field($this->pk)->select($options);
        $map = array();
        foreach ($this->lists as $list)
        {
            $map[$this->fk] = $list[$this->pk];

            // 查询依赖表 （以下注释为示例代码，并无实际意义）
            foreach ($this->dependencies as $dependency)
            {
                $this->_checkIsObject($dependency);

                if ($dependency->where($map)->count() > 0)
                {
                    $this->setError(get_class($this) . " prepare Error: " . get_class($dependency) . " dependency error: " . $this->fk ." has datas with " . $list[$this->pk]);
                    return false;
                }
            }

            // 预删除关联表 
            foreach ($this->relationals as $relational)
            {
                // 进行对象类型的检查
                $this->_checkIsObject($relational);
                
                // 预删除
                if ($relational->where($map)->prepareDelete() === false)
                {
                    $this->setError(get_class($this) . " prepare Error: " . get_class($dependency) . " relational with " . $this->pk . ":" . $list[$this->pk] ." error: " . $relational->getError());
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 检测传入类型是否为对象
     * @param  object $object 
     * @return bool         
     * panjie 
     * 2016.05
     */
    private function _checkIsObject($object)
    {
        if (!is_object($object))
        {
            E("dependencies or relationals must be object");
        }
    }

    /**
     * 根据表名及前缀名，自动生成外键
     * @return  
     */
    private function _makeFk()
    {
        // 取当前的名称
        $name = $this->name;

        // 匹配大写被字母
        preg_match_all( '/[A-Z]/', $name, $matches, PREG_OFFSET_CAPTURE );
        $match = $matches[0];

        // 按规则进行大小写转换，并且进行拼接
        $name = strtolower($this->name);
        for ($i = count($match) - 1; $i > 0 ; $i--)
        {
            $name = substr_replace($name, '_', $match[$i][1], 0);
        }
        $this->fk = $name . '_id';
    }
}