<?php

namespace Card\Logic;

use Card\Model\CardModel;
use CardBatch\Logic\CardBatchLogic;

class CardLogic extends CardModel
{
    protected $CardBatchL = null;

    /**
     * 创建一个密码的算法
     * 传过来$str是20随机字符串
     * 先sha1,去前20位再md5
     * 返回20位卡密密码
     */
    public function getPasswordByStr($str = "")
    {
        if (trim($str) == "") {
            return false;
        }
        $data =  md5(substr(sha1(trim($str)), 0,19));
        return $data;
    }

    /**
     * 验证用户名密码是否正确
     * @param string $num 卡号
     * @param string $key 密码
     * @return 正确返回卡密的ID，错误返回false
     * @author litian
     */
    public function validate($num,$key = "")
    {
        // 查询匹配卡号
        $map['number'] = $num;
        $data = $this->where($map)->find();

        // 判断信息是否正确
        if (!is_array($data))
        {
            $this->setError("num or key incorect");
            return false;
        }

        //判断是否使用
        if ((int)$data['is_use'] === 1)
        {
            $this->setError("cdkey is used");
            return false;
        }

        // 匹配查询卡密批次表
        $map = array();
        $CardBatchL = new CardBatchLogic();
        $map['id'] = $data['card_batch_id'];
        $list = $CardBatchL->where($map)->find();

        // 判断是否过期
        if (time() > (int)$list['deadline'])
        {
            $this->setError("cdkey is expired");
            return false;
        }

        //判断密码
        if ($data['password'] === $this->getPasswordByStr($key)) {
            return $data['id'];
        }

        $this->setError("cdkey is incorect");
        return false;
    }

    /**
     * 添加学生id到卡密表
     * @param  string $num 卡号
     * @param  string $key 密码
     * @param  int $studentId 学生id
     * @return bool 添加成功返回卡密ID 失败返回0
     */
    public function updateListByIdWithStudentId($id, $studentId)
    {
        // 更新数据
        $data['id'] = (int)$id;
        $data['student_id'] = (int)$studentId;
        $data['is_use'] = 1;
        return $this->saveList($data);
    }

}
