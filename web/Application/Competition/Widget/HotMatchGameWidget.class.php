<?php
namespace Competition\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class HotMatchGameWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'sort desc')
	{
		//$hotmatches = S('competition_hot_match_list');
		if (empty($hotmatches)) {
			$map['game_status']<2;
			$hotmatches = D('MatchGame')->getMatchGamesInfo($map,8,'follows desc');
			S('competition_hot_match_list', $hotmatches, 3000);
		}
		$this->assign('hotmatches', $hotmatches);
		$this->display('Widget/hotMatchGameList');
	}
}