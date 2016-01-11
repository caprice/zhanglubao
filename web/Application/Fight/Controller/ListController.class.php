<?php

namespace Fight\Controller;

class ListController extends BaseController {
	
	
	
	public function index() {
		$this->display ();
	}
	
	
	
	public function view($id) {
		$map ['status'] = 1;
		$map ['game_id'] = $id;
		$list = $this->lists ( 'Fight', 32, $map );
		$games = D ( 'Game' )->getAllChildren ();
		$this->assign ( 'games', $games );
		$this->assign ( '_list', $list );
		$this->assign ( 'gameid', $id );
		$this->display ();
	}
	
	
	public function games() {
		// $games = S('fight_list_games');
		if (empty ( $games )) {
			$map ['pid'] = 1;
			$games = D ( 'Game' )->getGamesInfo ( $map, null );
			S ( 'fight_list_games', $games, 3000 );
		}
		$this->assign ( 'games', $games );
		$this->display ();
	}
}