<?php

namespace Live\Controller;


class ListController extends BaseController {
	
	
	public function view($id) {
		 
		$map ['game_id'] = $id;
		$list = $this->lists ( 'Live', 32, $map );
		$this->assign ( '_list', $list );
		$this->assign ( 'gameid', $id );
		$this->display ();
	}
	
	public function  hot()
	{
		$map=array();
		$list = $this->lists ( 'Live', 32, $map,'follows desc' );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	public function fresh()
	{
		$map=array();
		$list = $this->lists ( 'Live', 32, $map,'id desc' );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	
	public function  games()
	{
		 //$games = S('live_list_games');
		if (empty($games)) {
			$map['pid']=1;
			$games = D('Game')->getGamesInfo($map,null);
			S('live_list_games', $games, 3000);
		}
		$this->assign('games', $games);
		$this->display();
	}
}