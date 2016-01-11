<?php
namespace Home\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexAnchorsWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
        //$anchors = S('index_anchors_list');
        if (empty($anchors)) {
        	$map['status']=1;
            $anchors = D('Live')->getLivesInfo($map,9,'follows desc');
            S('index_anchors_list', $anchors, 3000);
        }
        
        
        $this->assign('anchors', $anchors);
        $this->display('Widget/Index/anchorsList');
    }
}