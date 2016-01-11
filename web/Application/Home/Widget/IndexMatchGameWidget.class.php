<?php
namespace Home\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexMatchGameWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
         //$matches = S('index_match_list');
        if (empty($matches)) {
        	$map['status']=1;
        	$map['game_status']=array('lt',2);
            $matches = D('MatchGame')->getMatchGamesInfo($map,4);
            S('index_match_list', $matches, 3000);
        }
        $this->assign('matches', $matches);
        $this->display('Widget/Index/matchList');
    }
}