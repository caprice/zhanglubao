<?php
namespace Live\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexNewAnchorsWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
        //$newanchors = S('live_index_nanchors');
        if (empty($newanchors)) {
        	$map['status']=1;
            $newanchors = D('Live')->getLivesInfo($map,9,'id desc');
            S('live_index_nanchors', $newanchors, 3000);
        }
        $this->assign('newanchors', $newanchors);
        $this->display('Widget/Index/newanchors');
    }
}