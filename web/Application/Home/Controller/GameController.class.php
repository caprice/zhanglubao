<?php
namespace Home\Controller;
use Think\Controller;

class GameController extends BaseController {

	public function  view($name)
	{
		$GameModel=D('Game');
		$game=$GameModel->getGameByName($name);
		if (!$game) {
			$this->error('找不到游戏');
		}
	 
		$this->assign('game',$game);
		$this->display();
	}
	
	 
}
?>