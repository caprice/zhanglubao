<?php

namespace Video\Widget;
use Think\Action;


class SideUserWidget extends Action{
	
	
	public function hots($map = '', $order = 'uid asc')
	{
		 $hotusers = S('v_i_hotusers');
		if (empty($hotusers)) {
			$map['status']=1;
			$map['user_verify']=1;
			$hotusers = D('UserUser')->getUsersInfo($map,60);
			S('v_i_hotusers', $hotusers, 86000);
		}
	
		$this->assign('hotusers', $hotusers);
		$this->display('Widget/Side/sidehotusers');
	}
}

?>