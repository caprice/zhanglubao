<?php

namespace Competition\Controller;

class MatchGameController extends BaseController {
	
	public function  index()
	{
		$list = $this->lists ( 'MatchGame' );
		$this->assign ( '_list', $list );
		$this->display();
	}
	
	public function view($id) {
		empty ( $id ) && $this->error ( '参数不能为空！' );
		$matchgame = D ( 'MatchGame' )->getMatchGameInfo ( $id );
		empty ( $matchgame ) && $this->error ( '比赛不存在！' );
		
		$redmembers = D ( 'MatchGameMember' )->getMembers ( $matchgame ['red_team'], $matchgame ['id'] );
		$bluemembers = D ( 'MatchGameMember' )->getMembers ( $matchgame ['blue_team'], $matchgame ['id'] );
		$nearmatchgames = D ( 'MatchGame' )->getNearMatchGames ( $id, $matchgame ['match_id'] );
		
		$this->assign ( 'redmembers', $redmembers );
		$this->assign ( 'bluemembers', $bluemembers );
		$this->assign ( 'matchgame', $matchgame );
		$this->assign ( 'nearmatchgames', $nearmatchgames );
		$matchvideos = D ( 'MatchVideo' )->getLatestVideo ( $matchgame ['match_id'] );
		$this->assign ( 'matchvideos', $matchvideos );
		if ($matchgame ['game_status'] == 0 ||$matchgame['blue_team']==0||$matchgame['red_team']==0) {
			$this->display ( 'view' );
		} elseif ($matchgame ['game_status'] == 1) {
			
			$livemap['match_game_id']=$id;
			$lives=D('MatchGameLive')->getLivesInfo($livemap);
			
			$currentlive=D('Live')->getLiveInfo($matchgame['live_id']);
			
			$this->assign('currentlive',$currentlive);
			$this->assign('lives',$lives);
			
			
			
			$gamemap['match_game_id']=$id;
			$gamevideos=D('MatchGameVideo')->getVideosInfo($gamemap);
			$this->assign('gamevideos',$gamevideos);
			
			$this->display ( 'live' );
			
			
		} else {
			
			$gamemap['match_game_id']=$id;
			$gamevideos=D('MatchGameVideo')->getVideosInfo($gamemap);
			$this->assign('gamevideos',$gamevideos);
			$this->display ( 'over' );
		}
	}
}