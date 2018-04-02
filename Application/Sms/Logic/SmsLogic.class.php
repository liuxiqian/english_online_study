<?php
/**
* 短信接收
*/
namespace Sms\Logic;

class SmsLogic
{
    protected $error = "";
    protected $statusStr = array();
    protected $smsapi = "";
    protected $user = "";
    protected $pass = "";

    public function __construct()
    {
         $this->statusStr = array(
            "0" => "success",
            "-1" => "miss params",
            "-2" => "curl  or fsocket function not found!",
            "30" => "password wrong",
            "40" => "count not exist",
            "41" => "money less than 0",
            "42" => "count is out of date",
            "43" => "IP address not allowed",
            "50" => "content not allowed"
            );  
        $this->smsapi = "http://www.smsbao.com/"; //短信网关
        $this->user = "yunzhi"; //短信平台帐号
        $this->pass = md5("yunzhi.club"); //短信平台密码
    }
    public function setError($error)
    {
        $this->error = $error;
    }
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * 发送短消息
     * @param string $code  验证码
     * @param string $content  短消息内容
     * @param string $phone  手机号
     * return 发送成成 true 失败 false
     */
    public function setMessage($code, $content = "", $phone = null)
    {   
        //设置默认值
        if ($phone === null)
        {
            $phone = C("AUTCH_CODE_PHONE");
        }

        //设置默认值
        if ($content === "")
        {
            $content = "【一鑫在线英语学习系统】您正在进行生成卡密的操作，请勿向任何人泄露，您的验证码为" . $code ."，在5分钟内有效。";//要发送的短信内容
        }

        //短信发送
        $sendurl = $this->smsapi."sms?u=".$this->user."&p=".$this->pass."&m=".$phone."&c=".urlencode($content);
        $result = file_get_contents($sendurl);
        if( $result == "0" ){
            return true;
        }
        else{
            $this->setError($this->statusStr[$result]);
            return false;
        }
    }
}
