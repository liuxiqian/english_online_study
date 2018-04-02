<?php
/**
 * xulinjie
 * 卡密管理
 */
namespace Admin\Controller;

use Admin\Model\Card\BaseModel;
use Sms\Logic\SmsLogic;
use Card\Logic\CardLogic;
use CardBatch\Logic\CardBatchLogic;     //卡密批次表
use Yunzhi\Logic\PHPExcelLogic;     //phpexcel
use Admin\Model\File;

class CardController extends AdminController
{
    protected $M         = null;
    protected $CardL     = null;
    protected $CardBatch = null;

    private $appPath;
    private $path;

	public function __construct(){
        parent::__construct();

        $this->appPath = dirname(THINK_PATH) . '/Public';
        $this->path = $this->appPath . '/download';

        $this->M         = new BaseModel();
        $this->CardL     = new CardLogic();
        $this->CardBatch = new CardBatchLogic();

        $this->assign("M", $this->M);
    }

    public function indexAction(){
    	$this->display();
    }

    public function addAction(){
        $phone = C("AUTCH_CODE_PHONE");
        $rePhone = substr_replace($phone,"****", 3, 4);
        $this->assign('rePhone',$rePhone);
    	$this->display();
    }

    /**
     * 删除卡密
     * @author xulinjie
     */
    public function deleteAction()
    {
        $jumpUrl = U("index?filename=", I('get.'));
        $filename = I('get.filename');
        $pathname = $this->path . '/' . $filename . '.xls';
        // dump($pathname);
        // exit();
        // $pathname = 'C:/Users/lenovo/Desktop/1.txt';
        try
        {
            $File = new File($pathname);
            if ($File->delete() === false)
            {
                $this->error("删除错误：" . $File->getError(), $jumpUrl);
                return;
            }
        }
        catch(\Exception $e)
        {
            $this->error("删除错误：" . $File->getError(), $jumpUrl);
            return;
        }
        $this->success("删除成功:", $jumpUrl);
    }

    public function writeExcelAction(){
        $list = I('post.');
        $list['deadline'] = strtotime($list['deadline']);
        // dump($list);
        // exit();

        //判断生成数量是否大于100
        if ((int)$list['num'] > 100) {
            $this->error("操作错误:生成数量不能大于100",U('Card/add'));
            return;
        }
        else{
            $lenght = (int)$list['num'];
        }

        $user = $this->getUser();//获取当前用户信息
        try
        {
            //配置卡密批次表
            $url = "download/".$list['batch'];//生成卡密批次的url
            $cardBatchList['batch']             = $list['batch'];
            $cardBatchList['user_id']           = $user['id'];
            $cardBatchList['generate_date']     = time();
            $cardBatchList['effective_days']    = $list['effective_days'];
            $cardBatchList['deadline']          = $list['deadline'];
            $cardBatchList['url']               = $url;

            //保存卡密批次表
            $cardBatchListId = $this->CardBatch->saveList($cardBatchList);
            if ($cardBatchListId === false) {
                $this->error("操作错误:".$this->CardBatch->getError(),U('Card/index'));
                return;
            }

            //生成excel数组
            $data = array(
                array('number' => '卡号', 'password' => '密码', 'batch' => '批次', 'deadline' => '截止日期', 'effective_days' => '有效期(天)'));
            for ($i = 1; $i <= $lenght; $i++) {
                $number = $this->M->getNumber($list['batch']);//卡号
                $end = 1000+$i;
                $number = $number.$end;
                // dump($number);
                // exit();
                $str = create_noncestr(20);//生成20位随机字符串作为密码

                //配置excel的每一条卡密信息
                $data[$i]['number']           = $number;
                $data[$i]['password']         = $str;
                $data[$i]['batch']            = $list['batch'];
                $data[$i]['deadline']         = date("Y.m.d",$list['deadline']);
                $data[$i]['effective_days']   = $list['effective_days'];

                //保存
                $saveList['card_batch_id']  = $cardBatchListId;
                $saveList['number']         = $number;
                $saveList['password']       = $this->CardL->getPasswordByStr($str);//密码加密

                //如果保存出错
                //删除对应批次表的信息
                if ($this->CardL->saveList($saveList) === false){
                    $this->CardBatch->deleteListById($cardBatchListId);
                    $this->error("保存错误:".$this->CardL->getError(),U('Card/add'));
                    return;
                }
            }

            // 将数组中的值写入EXCEL，供用户下载
            $ReadL = new PHPExcelLogic();

            //添加数据并生成excel文件
            $ReadL->arrayToExcel($data)->save("$url");

            $this->success("操作成功！",U('Card/index'));
        }
        catch(\Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * 给手机发送验证码的方法
     * 通过前台的生成卡密界面来做
     * xulinjie
     * @return ajax
     */
    public function getAuthCodeAction()
	{
		$data = array("status"=>"ERROR");
        $phoneCode = create_phoneCode();//随机生成6位的手机验证码数字
        session("phoneCode",$phoneCode);

        $SmsL = new SmsLogic();
        if ($SmsL->setMessage($phoneCode) === false) {
            $data['result'] = $SmsL->getError();
        }
        else{
            $data['status'] = "SUCCESS";
        }

		$this->ajaxReturn($data);
	}

    /**
     * 验证手机验证码是否正确
     * xulinjie
     * @return ajax
     */
    public function verifyAction($code = null)
    {
        if ($code === null) {
            $data = array("status"=>"ERROR");
            $data['message'] = "验证码为空";
        }
        else{
            $phoneCode = session("phoneCode");
            // $phoneCode = "123456";

            if ($phoneCode === null) {
                $data['message'] = "请重新获取验证码！";
            }
            if ( $phoneCode == $code ) {
                $data['status'] = "SUCCESS";
            }
            else{
                $data['message'] = "输入的验证码不正确！";
            }
        }
        $this->ajaxReturn($data);
    }
}