<?php

namespace Video\Widget;

use Think\Action;

class SideRecWidget extends Action {
	
	
	public function videos() {
		$siderecs = S ( 'v_i_recv_vs' );
		if (empty ( $siderecs )) {
			$map ['status'] = 1;
			$siderecs =  D('RecommendContent')->getRecsInfo($map,10);
			S ( 'v_i_recv_vs', $siderecs, 8600 );
		}
		$this->assign('siderecs',$siderecs);
		$this->display('Widget/Side/siderecvideos');
	}
}

?>