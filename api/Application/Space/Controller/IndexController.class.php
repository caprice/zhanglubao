<?php

namespace Space\Controller;

class IndexController extends BaseSpaceController{
	
	public function index()
	{
		$list = $this->listus(D('UserUser'));
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	
}

?>