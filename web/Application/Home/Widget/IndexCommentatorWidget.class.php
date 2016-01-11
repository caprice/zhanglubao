<?php
namespace Home\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexCommentatorWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
        $commentators = S('index_commentator_list');
        if (empty($commentators)) {
        	$map['status']=1;
            $commentators = D('Commentator')->getCommentatorsInfo($map,12);
            S('index_commentator_list', $commentators, 3000);
        }
        $this->assign('commentators', $commentators);
        $this->display('Widget/Index/commentatorList');
    }
}