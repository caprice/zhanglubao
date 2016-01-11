<?php
namespace Team\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class IndexTeamWidget extends Action
{
	/* 显示指定分类的同级分类或子分类列表 */
	public function lists($map = '', $order = 'id desc')
	{
		 
		//$teams = S('team_index_teams');
		if (empty($teams)) {
			$teams = D('Team')->getTeamsInfo($map,20,$order);
			S('team_index_teams', $teams, 3000);
		}
		$this->assign('teams', $teams);
		$this->display('Widget/Index/teams');
	}
}