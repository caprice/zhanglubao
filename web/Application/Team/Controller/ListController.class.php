<?php
namespace Team\Controller;


class ListController extends BaseController {

	public  function  view($id)
	{
		
		$map ['game_id'] = $id;
		$list = $this->lists ( 'Team', 32, $map );
		$games = D ( 'Game' )->getAllChildren ();
		$this->assign ( 'games', $games );
		$this->assign ( '_list', $list );
		$this->assign ( 'gameid', $id );
		$this->display();
	}
}