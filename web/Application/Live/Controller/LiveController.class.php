<?php

namespace Live\Controller;


class LiveController extends BaseController {
	
	
	public function view($id) {
		
		$live=D('Live')->getLiveInfo($id);
		$this->assign('live',$live);
		$this->display();
	}
	
}