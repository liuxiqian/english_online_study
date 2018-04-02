<?php
/*
附件管理类
liuxi
 */
namespace Home\Model;

use Attachment\Logic\AttachmentLogic;

class Attachment
{
    private $id = 0;            // 附件id
    private $url = "";          // 附件url
    private $path = '';         // 上传的默认文件夹
    private $savepath = '';     
    private $savename = '';     
    private $ext = '';

    public function __construct($id = 0)
    {
        $id = (int)$id;
        $this->path = $path = __ROOT__ .'/uploads';   //图片路径
        $AttachmentL = new AttachmentLogic();
        $attachment = $AttachmentL->where("id=" . $id)->find();
        if ($attachment !== null)
        {
            $this->id = $attachment['id'];
            $this->url = $path . $attachment['savepath'] . $attachment['savename'] . '.' . $attachment['ext'];
            $this->savepath = $attachment['savepath'];
            $this->savename = $attachment['savename'];
            $this->ext      = $attachment['ext'];
        }
        else
        {
            $this->id = 0;
            $path = dirname($path) == DIRECTORY_SEPARATOR ? '' : dirname($path) ;
            $this->url = $path . '/images/liming.jpg';    //默认图片
        }
    }

    public function getId()
    {
        return (int)$this->id;

    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getSavepath()
    {
        return $this->savepath;
    }

    public function getSavename()
    {
        return $this->savename;
    }

    public function getExt()
    {
        return $this->ext;
    }

    public function getAudioUrl()
    {
        if (null === $this->audioUrl)
        {
            if (0 === $this->getId())
            {
                $this->audioUrl = __ROOT__ . '/audio/uk/_default.mp3';
            } else {
                $this->audioUrl = __ROOT__ . '/audio' . $this->getSavepath() . $this->getSavename() . '.' . $this->getExt();
            }
        }

        return $this->audioUrl;
    }
}