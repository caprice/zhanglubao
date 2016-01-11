<?php

namespace Video\Widget;
use Think\Action;
class SideTeamWidget extends Action{
	
	
	public function teams($map = '', $order = 'uid asc')
	{
		 $teams = S('v_i_sts');
		if (empty($teams)) {
			$map['status']=1;
			$map['group_id']=6;
			$teams = D('UserUser')->getUsersInfo($map,16);
			S('v_i_sts', $teams, 86000);
		}
	
		$this->assign('teams', $teams);
		$this->display('Widget/Side/sideteams');
	}
}

?>