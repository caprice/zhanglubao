<?php

namespace Fight\Controller;

class FightController extends BaseController {
	
	public function  view($id)
	{
		$fight=D('Fight')->getFightInfo($id);
		$joins=D('FightJoin')->getFightJoinId($id);
		$this->assign('joins',$joins);
		$this->assign('fight',$fight);
		$this->display();
	}
	
}