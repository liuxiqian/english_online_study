<?php
namespace Admin\Controller;
use Home\Model\Article;                     // 文章
use Article\Model\ArticleModel;             // 阅读闯关
use Attachment\Logic\AttachmentLogic;       // 附件
use Home\Model\Attachment;                  // 附件
use Home\Model\Upload;                      // 上传


class ArticleController extends AdminController
{
    public function editAction()
    {
        $Article = new Article(I('get.id'));
        if (0 === $Article->getId())
        {
            $this->error('您所编辑的记录不存在', U('index?id=', I('get.')));
            return;
        }

        $this->assign('Article', $Article);
        $this->display();
    }

    public function addAction()
    {
        $Article = new Article;

        $this->assign('Article', $Article);
        $this->display('edit');
    }

    public function saveAction()
    {
        $id = (int)I('post.id');
        $Article = new Article($id);

        $article = array();

        // 新增
        if (0 !== $Article->getId())
        {  
            $article['id'] = $Article->getId();
        }
        $article['title'] = I('post.title');
        $article['attachment_id'] = I('post.attachment_id');
        $article['english_text'] = I('post.english_text');
        $article['chinese_text'] = I('post.chinese_text');

        $ArticleM = new ArticleModel;
        if (!$ArticleM->saveList($article))
        {
            $this->error('系统错误:' . $ArticleM->getError(), U('index?id=', I('get.')));
            return;
        }
        
        $this->success('操作成功', U('index?id=', I('get.')));
    }

    public function deleteAction()
    {

    }

    public function indexAction()
    {
        $Article = new Article;
        $this->assign('Article', $Article);
        $this->display();
    }

    public function uploadAudioAjaxAction()
    {
        $result['state'] = 'ERROR';

        // 定制上传配置信息
        $config = array(
            'mimes'         =>  array('audio/*', 'audio/mpeg'), //允许上传的文件MiMe类型
            'maxSize'       =>  10240000, //上传的文件大小限制 (0-不做限制)
            'exts'          =>  array('mp3'), //允许上传的文件后缀
            'autoSub'       =>  false, //自动子目录保存文件
            'subName'       =>  array('date', 'Ymd'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath'      =>  './audio/', //保存根路径
            'savePath'      =>  'article' . '/', //保存路径
            'saveExt'       =>  '', //文件保存后缀，空则使用原后缀
            'hash'          =>  true, //是否生成hash编码
            'callback'      =>  false, //检测文件是否存在回调，如果存在返回文件信息数组
            );

        // 实例化上传类
        $Upload = new Upload($config);
        $Attachment = $Upload->checkIsExist(true)->uploadOne($_FILES['yunzhifile']);
        if (false === $Attachment)
        {
            $result['message'] = $Upload->getError();
            $this->ajaxReturn($result);
            return;
        }

        // 写入结果
        $result = array();
        $result['id'] =  $Attachment->getId();
        $result['url'] = $Attachment->getAudioUrl();

        if (0 === $Attachment->getId())
        {
            $result['message'] = '访问的附件不存在';
            $this->ajaxReturn($result);
            return;
        }

        $result['state'] = 'SUCCESS';
        $this->ajaxReturn($result);
        return;
    }
}