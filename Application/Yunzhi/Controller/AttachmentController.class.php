<?php
/**
 * 附件管理
 * 实际附件上传的统一入口
 */
namespace Yunzhi\Controller;

use Think\Controller;
use Yunzhi\Logic\AttachmentLogic;

class AttachmentController extends Controller
{
    public function configAction() {
        $this->display("config.js");
    }
    
    public function uploadAction() 
    {   
    	C('TOKEN_ON',false); //关闭令牌
    	
		$userId 	= 0;

		//获取配置信息
		$configFile = APP_PATH . "Yunzhi/Conf/ueditor.json";
		$config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($configFile)), true);
		
		$Ueditor 		= new \Org\Util\Ueditor($userId, $config);
		$data = $Ueditor->getResult();

		//返回成功，写入数据库
		if ($data['state'] == "SUCCESS")
		{
			//php5.5可以这样写 class_exists(AttachmentLogic::class)
			//php版本小于5.5要这样写  if (class_exists('Yunzhi\Logic\AttachmentLogic'))
			if (class_exists('Yunzhi\Logic\AttachmentLogic'))
			{
				$AttachmentL = new AttachmentLogic();
				if ($attachmentId = $AttachmentL->addRecordList($data))
				{
					$data['id'] = $attachmentId;
				}
				else
				{
					$data['state'] = "Attachment save error, msg:" . $AttachmentL->getError();
				}
			}
			else
			{
				$data['state'] = "AttachmentLogic not found";
			}
		}
		echo json_encode($data);
    }        
}
