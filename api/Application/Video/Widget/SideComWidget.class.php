<?php

namespace Video\Widget;
use Think\Action;
class SideComWidget extends Action{
	
	
	public function users($map = '', $order = 'uid asc')
	{
		 $users = S('v_i_scs');
		if (empty($users)) {
			$map['status']=1;
			$map['group_id']=3;
			$users = D('UserUser')->getUsersInfo($map,48);
			S('v_i_scs', $users, 86000);
		}
	
		$this->assign('users', $users);
		$this->display('Widget/Side/sidecoms');
	}
}

?>