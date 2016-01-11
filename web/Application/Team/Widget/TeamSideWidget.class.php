<?php
namespace Team\Widget;

use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class TeamSideWidget extends Action
{
 
	/* 显示指定分类的同级分类或子分类列表 */
	public function hot($teamid)
	{

		$videos = D ( 'TeamVideo' )->getTeamVideo ( $teamid,10);
		$this->assign('sidevideos',$videos);
		$this->display('Widget/Side/hot');
	}
	
	
}