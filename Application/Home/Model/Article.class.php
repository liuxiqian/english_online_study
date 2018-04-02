<?php

namespace Home\Model;

use Article\Model\ArticleModel;
use ArticleKlass\Model\ArticleKlassModel;

class Article extends Model
{
    static $ArticleModel = NULL;
    public $data = ['_class' => __CLASS__];                    // 数据总数
    private $totalCount = 0;                             // 班级
    private $Klass;
    private $Attachment = NULL;

    public function __construct($data = NULL)
    {
        if (!is_null($data)) {
            if (is_array($data)) {
                $this->data = $data;
            } else {
                $id = (int)$data;
                $data = self::getArticleModel()->where('id=' . $id)->find();
                if (NULL !== $data) {
                    $this->setData($data);
                }
            }
        }
    }

    static function getArticleModel()
    {
        if (is_null(self::$ArticleModel)) {
            self::$ArticleModel = new ArticleModel();
        }

        return self::$ArticleModel;
    }

    /**
     * 获取全部的课程
     * 如果该课程属于传入班级，则默认选中
     * @param  Klass &$Klass 班级
     * @return array         课程
     */
    static public function getArticles(&$Klass)
    {
        $data = Cache::get(__CLASS__, __FUNCTION__, $Klass->getId());
        if (FALSE === $data) {
            $datas = self::getArticleModel()->getAllLists(array('id'));
            foreach ($datas as &$data) {
                $data = new Article($data);
                $data->setKlass($Klass);
            };
            Cache::set(__CLASS__, __FUNCTION__, $Klass->getId(), $datas);
        }

        return $datas;
    }

    public function getAttachment()
    {
        if (NULL === $this->Attachment) {
            $this->Attachment = new Attachment($this->getAttachmentId());
        }

        return $this->Attachment;
    }

    public function getLists($maps = array())
    {
        $backFields = array('id');
        $lists = self::getArticleModel()->getLists($backFields, $maps);
        $this->totalCount = self::getArticleModel()->getTotalCount();
        $datas = array();
        foreach ($lists as $list) {
            $datas[] = new Article($list['id']);
        }

        return $datas;
    }

    public function getTotalCount()
    {
        return (int)$this->totalCount;
    }

    //public function jsonSerialize()
    //{
    //    $isKlassOwned = FALSE;
    //    if (NULL !== $this->getKlass()) {
    //        $ArticleKlassM = new ArticleKlassModel;
    //        $map['klass_id'] = $this->getKlass()->getId();
    //        $map['article_id'] = $this->getId();
    //        $articleKlass = $ArticleKlassM->where($map)->find();
    //        if (NULL !== $articleKlass) {
    //            $isKlassOwned = TRUE;
    //        }
    //        unset($ArticleKlassM);
    //    }
    //
    //    return [
    //        'id'           => $this->getId(),
    //        'title'        => $this->getTitle(),
    //        'isKlassOwned' => $isKlassOwned,
    //        'info'         => '',
    //    ];
    //}

    public function getKlass()
    {
        if (is_null($this->Klass)) {
            $this->Klass = new Klass($this->getData('klass_id'));
        }

        return $this->Klass;
    }

    public function setKlass($Klass)
    {
        $this->Klass = $Klass;
    }
}