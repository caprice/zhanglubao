<?php

namespace Video\Controller;

class ListController extends BaseController {
	
	
	public function view($id) {
		$map ['game_id'] = $id;
		$list = $this->lists ( 'Video', 32, $map );
		$games = D ( 'Game' )->getAllChildren ();
		$this->assign ( 'games', $games );
		$this->assign ( '_list', $list );
		$this->assign ( 'gameid', $id );
		$this->display ();
	}
	
	
	
	public function recommend($id = null) {
		$map = array ();
		if ($id) {
			$map ['game_id'] = $id;
		}
		$map['edit_status']=1;
		$list = $this->lists ( 'Video', 32, $map );
		$games = D ( 'Game' )->getAllChildren ();
		$this->assign ( 'games', $games );
		$this->assign ( '_list', $list );
		$this->display ();
	}
}

?>