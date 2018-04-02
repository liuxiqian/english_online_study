<?php
/**
 * 用户
 */
namespace User\Model;

use Yunzhi\Model\YunzhiModel;
use Student\Logic\StudentLogic;
use Klass\Logic\KlassLogic;
use CardBatch\Logic\CardBatchLogic;

class UserModel extends YunzhiModel
{
    //重写预删除
    public function prepareDelete(&$options = array())
    {
        if (empty($this->relationals))
        {
            $this->relationals = array(
                new KlassLogic
            );
        }
        if (empty($this->dependencies))
        {
            $this->dependencies = array(
                new StudentLogic,
                new CardBatchLogic
            );
        }
        return parent::prepareDelete($options);
    }

    protected $field        = "name"; //查询字段
    /**
     * 生成密码，所有的用户密码用成的环节，全部采用该方法
     * @param  string $password 加密前密码
     * @return string       加密后的密码
     * panjie
     * 2016.4
     */
    public function makePassword($password)
    {
        return sha1(substr(md5(trim($password)), 2));
    }

    /**
     * 重写父类的savelist方法
     * @param  list $data 一组数组
     * @return 调用父类 
     * panjie
     * 2016.4
     */
    public function saveList($data)
    {
        if (isset($data['password']))
        {
            $data['password'] = $this->makePassword($data['password']);
        }
        return parent::saveList($data);
    }
}