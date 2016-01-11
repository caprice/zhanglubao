<?php
namespace Home\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexLivesWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
         $lives = S('index_live_list');
        if (empty($lives)) {
        	$map['status']=1;
            $lives = D('Live')->getLivesInfo($map,8);
            S('index_live_list', $lives, 3000);
        }
        $this->assign('lives', $lives);
        $this->display('Widget/Index/liveList');
    }
}