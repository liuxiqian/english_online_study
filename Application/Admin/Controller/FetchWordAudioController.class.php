<?php
namespace Admin\Controller;

use Word\Model\WordModel;   // 单词
use Home\Model\Word;

/**
 * 抓取单词声音
 */
class FetchWordAudioController extends AdminController
{
    // 依次抓取所有的课程的单词读音
    public function indexAction()
    {
        // 取出所有的单词
        $WordM  = new WordModel;
        $words  = $WordM->field("title")->select();
        $dir   = $_SERVER['DOCUMENT_ROOT'] . dirname(__APP__ ) . '/audio';
        !is_dir($dir) && @mkdir($dir,0755,true);

        $url = "http://dict.youdao.com/dictvoice?audio=%s&type=%s"; // 抓取单词的URL

        // 依次进行查询
        foreach ($words as $word)
        {
            // 去首尾空格，将空格换成 _
            $fileName = Word::reMakeTitle($word['title']);
            $fileName .= '.mp3';

            $fetchs = array(
                array("1", '/uk/'),         // 抓取英式读音
                array("2", "/us/"));        // 抓取美式读音

            foreach ($fetchs as $fetch)
            {
                try
                {
                    $fetchUrl = sprintf($url, $word['title'], $fetch[0]);
                    $file = $dir . $fetch[1] . $fileName;
                    !is_dir(dirname($file)) && @mkdir(dirname($file),0755,true);
                    if (!is_file($file))
                    {
                        http_copy($fetchUrl, $file);
                        echo ++$i . ": Fetch " . $word['title'] . " done! <br />";
                    }
                } catch (\Think\Exception $e)
                {
                    echo $file . ' feteched error: ' . $e->getMessage() . '<br />';
                }
            }
            
        }

        $hr = "--------------------------------------------------<br />";
        echo "$hr All words audio has fetched.<br />";
        echo "$hr Power by <a href='http://www.mengyunzhi.com'>YUNZHICLUB</a>";
    }
}