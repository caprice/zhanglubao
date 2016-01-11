<?php
namespace video\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexMasterWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
        //$masters = S('video_index_master');
        if (empty($masters)) {
        	$map['status']=1;
            $masters = D('Master')->getMastersInfo($map,12);
            S('video_index_master', $masters, 3000);
        }
        $this->assign('masters', $masters);
        $this->display('Widget/Index/masters');
    }
}