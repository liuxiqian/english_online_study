<?php
namespace Home\Model;
use Think\Upload as ThinkUpload;
use Attachment\Logic\AttachmentLogic;       // 附件
class Upload extends ThinkUpload
{
    private $checkIsExist = false;

    public function __construct($config = array(), $driver = '', $driverConfig = null)
    {
        parent::__construct($config, $driver, $driverConfig);
    }

    public function checkIsExist($value = true)
    {
        if ($value === true)
        {
            $this->checkIsExist = true;
        } else {
            $this->checkIsExist = false;
        }

        return $this;
    }

    /**
     * 上传单一文件
     * @param  File $file 上传文件
     * @return Attachment       附件
     */
    public function uploadOne($file)        
    {
        $info = parent::uploadOne($file);

        if (!$info)
        {
            return false;
        } 

        $AttachmentL = new AttachmentLogic();
        // 如果存在附件，则写入更新信息. 不存在，则加入一个新的附件
        $id = (int)$info['id'];
        if ($this->checkIsExist && $id)
        {
            $attachment = $AttachmentL->where('id=' . $id)->find();
            unset($attachment['id']);               // 去除ID信息
            $attachment['record_id'] = $id;         // 写入关联ID
            $attachment['name'] = $info['name'];    // 写入附件名
            unset($attachment['create_time']);      // 去除创建信息
        } else {
            $attachment = array();
            $attachment['name'] = $info['name'];
            $attachment['record_id'] = (int)$info['id'];
            $attachment['savename'] = $info['savename'];
            $attachment['type'] = $info['type'];
            $attachment['size'] = $info['size'];
            $attachment['savepath'] = '/' . $info['savepath'];
            $attachment['sha1'] = $info['sha1'];
            $attachment['md5'] = $info['md5'];
            $attachment['ext'] = $info['ext'];
        }      

        $id = $AttachmentL->saveList($attachment);
        return new Attachment($id);
    }
}