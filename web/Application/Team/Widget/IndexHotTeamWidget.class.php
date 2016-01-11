<?php
namespace Team\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexHotTeamWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'members desc')
	{
		 
		//$hots = S('team_index_hots');
		if (empty($hots)) {
			$hots = D('Team')->getTeamsInfo($map,10,$order);
			S('team_index_hots', $hots, 3000);
		}
		$this->assign('hots', $hots);
		$this->display('Widget/Index/hots');
	}
}