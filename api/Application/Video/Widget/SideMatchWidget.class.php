<?php

namespace Video\Widget;
use Think\Action;
class SideMatchWidget extends Action{
	
	
	public function matches($map = '', $order = 'uid asc')
	{
		  $matches = S('v_i_sms');
		if (empty($matches)) {
			$map['status']=1;
			$map['group_id']=5;
			$matches = D('UserUser')->getUsersInfo($map,16);
			S('v_i_sms', $matches, 86000);
		}
	
		$this->assign('matches', $matches);
		$this->display('Widget/Side/sidematches');
	}
}

?>