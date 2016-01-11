<?php
namespace Live\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class ViewGamesWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort desc')
    {
        //$games = S('live_view_games');
        if (empty($games)) {
        	$map['pid']=1;
            $games = D('Game')->getGamesInfo($map,20);
            S('live_view_games', $games, 3000);
        }
        $this->assign('games', $games);
        $this->display('Widget/View/games');
    }
}