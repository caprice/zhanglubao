<?php

namespace Competition\Controller;

class VideoController extends BaseController {
	public function index() {
		
		
		$list = $this->lists ( 'MatchSeries' );
		$this->assign ( '_list', $list );
		$this->display ();
	}
}