<?php
namespace Fight\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexGamesWidget extends Action
{
    /* 显示指定分类的同级分类或子分类列表 */
    public function lists($map = '', $order = 'sort asc')
    {
        //$games = S('index_game_list');
        if (empty($games)) {
        	$map['pid']=1;
            $games = D('Game')->getGamesInfo($map,5,$order);
            S('index_game_list', $games, 3000);
        }
        $this->assign('games', $games);
        $this->display('Widget/Index/gameList');
    }
}