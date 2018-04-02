<?php
/**
 * 卡密小M层
 * 2016.04.15
 * xulinjie
 */
namespace Admin\Model\Card;

use CardBatch\Logic\CardBatchLogic;     //卡密批次表
use Card\Logic\CardLogic;     			//卡密表

class BaseModel
{
	protected $CardBatchL  = null;
	protected $CardL       = null;
	private   $appPath;
    private   $path;

 	public function __construct(){
 		$this->appPath = dirname(THINK_PATH) . '/Public';
        $this->path = $this->appPath . '/download';

		$this->CardBatchL = new CardBatchLogic();
		$this->CardL      = new CardLogic();
    }

    /**
     * 判断文件是否存在
     * @author xulinjie
     * @return true or false
     */
    public function isExist($batch)
    {
        $url = $this->path . '/' . $batch . '.xls';
        if (file_exists($url)) {
            return true;
        }
        else
            return false;
    }

    //联合查询取卡密有关信息
    public function getCardBatchLists()
    {
    	return $this->CardBatchL->getLists();
    }


	/**
	 * 生成卡号方法
	 * 传过来批次信息
	 * 前面为年月日，例如：20160415
	 * 加批次
	 * 加3位随机数
	 * 加循环的000-099
	 */
	public function getNumber($batch)
	{
		// 测试数据
		// $batch = "abc123456";
		// 获取当前时间
		$time = date("Ymd");
		// 随机数
		$number = rand(100,999);
		// 拼接
		$data = $time.$batch.$number;
		return $data;
	}

	/**
	 * 获取卡密表所有批次信息
	 * 返回一维数组
	 */

	public function getAllBatch()
	{

		$datas = $this->CardL->getAllLists();
		foreach ($datas as $key => $value) {
			$data[] = $value['batch'];
		}
		return $data;
	}

	//获取当前时间戳
	public function getBatch()
	{
		$res = time();
		return $res;
	}

	//取该批次生成个数
	public function getCardNumberByCardBatchId($id)
	{
		$maps['card_batch_id'] = $id;
		$this->CardL->setMaps($maps);
		$data = $this->CardL->getAllLists();
		$res = count($data);
		return $res;
	}

	//取该批次对应的卡密表is_use为1的个数
	public function getCardIsUseNumberByCardBatchId($id)
	{
		$maps['is_use'] = 1;
		$maps['card_batch_id'] = $id;
		$this->CardL->setMaps($maps);
		$data = $this->CardL->getAllLists();
		$res = count($data);
		return $res;
	}
}
