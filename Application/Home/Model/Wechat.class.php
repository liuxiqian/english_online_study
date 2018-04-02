<?php
namespace Home\Model;

use Wechat\Model\WechatModel;       // 微信M层
/**
 * 微信
 */
class Wechat
{
    private $id                 = 0;
    private $studentId          = 0;    // 学生ID
    private $attachmentId       = 0;    // 附件ID（二维码）
    private $officialAccountId  = 0;    // 公众号ID

    public function __construct($id)
    {
        $id = (int)$id;
        $WechatM = new WechatModel();
        $wechat = $WechatM->where("id="  . $id)->find();
        if (null !== $wechat)
        {
            $this->id = (int)$wechat['id'];
            $this->studentId = (int)$wechat['student_id'];
            $this->attachmentId = (int)$wechat['attachment_id'];
            $this->officialAccountId = (int)$wechat['official_account_id'];
        }
        unset($WechatM);
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function getStudentId()
    {
        return (int)$this->studentId;
    }

    public function getAttachmentId()
    {
        return (int)$this->getAttachmentId;
    }

    public function getOfficalAccountId()
    {
        return (int)$this->officialAccountId;
    }



}