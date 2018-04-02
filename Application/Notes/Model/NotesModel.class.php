<?php
namespace Notes\Model;
use Yunzhi\Model\YunzhiModel;

/**
 * 教务笔记
 */
class NotesModel extends YunzhiModel
{
    protected $_auto = array(
        array('time','time',1,'function'),
    );
}