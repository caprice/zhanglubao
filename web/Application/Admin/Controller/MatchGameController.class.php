<?php

namespace Admin\Controller;

use Org\Util\Date;

class MatchGameController extends AdminController {
	public function index() {
		$matchid = I ( 'matchid' );
		empty ( $matchid ) && $this->error ( '参数错误！' );
		$map ['match_id'] = $matchid;
		$list = $this->lists ( 'MatchGame', $map );
		int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->meta_title = '小组赛';
		$this->assign ( 'matchid', $matchid );
		$this->display ();
	}
	public function add($matchid = null) {
		if (IS_POST) {
			
			$MatchGame = D ( 'MatchGame' );
			$res = $MatchGame->update ();
			
			$red_team_name = trim ( query_team ( 'name', I ( 'post.red_team' ) ) );
			$bule_team_name = trim ( query_team ( 'name', I ( 'post.blue_team' ) ) );
			
			$map ['tid'] = I ( 'post.blue_team' );
			$members = D ( 'TeamMember' )->getMembersInfo ( $map );
			foreach ( $members as $member ) {
				$data ['uid'] = $member ['uid'];
				$data ['match_game_id'] = $res;
				$data ['game_place'] = $member ['place'];
				$data ['team_id'] = $member ['tid'];
				D ( 'MatchGameMember' )->add ( $data );
			}
			
			$map ['tid'] = I ( 'post.red_team' );
			$members = D ( 'TeamMember' )->getMembersInfo ( $map );
			
			foreach ( $members as $member ) {
				$data ['uid'] = $member ['uid'];
				$data ['match_game_id'] = $res;
				$data ['game_place'] = $member ['place'];
				$data ['team_id'] = $member ['tid'];
				D ( 'MatchGameMember' )->add ( $data );
			}
			
			$guess ['end_time'] = I ( 'post.start_time' );
			$guess ['match_game_id'] = $res;
			$guess ['game_id'] = I ( 'post.game_id' );
			$guess ['match_id'] = I ( 'post.match_id' );

			$GuessWin = D ( 'GuessWin' );
			$resGuess = $GuessWin->addGuessWin ( $guess );
			
			if (false !== $resGuess) {
				$this->success ( '新增成功！', U ( 'index?matchid=' . I ( 'match_id' ) ) );
			} else {
				$error = $GuessWin->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			empty ( $matchid ) && $this->error ( '参数错误！' );
			$games = $this->getGames ();
			$teams = $this->getTeams ( $matchid );
			
			$this->assign ( 'teams', $teams );
			$this->assign ( 'match_id', $matchid );
			$this->assign ( 'games', $games );
			$this->meta_title = '添加小组赛';
			$this->display ( 'edit' );
		}
	}
	private function getTeams($matchid = null) {
		empty ( $matchid ) && $this->error ( '参数错误！' );
		$game_id = query_match ( 'game_id', $matchid );
		$map ['game_id'] = $game_id;
		$teams = D ( 'Team' )->where ( $map )->select ();
		return $teams;
	}
	public function edit($id = null, $matchid = null) {
		if (IS_POST) {
			$MatchGame = D ( 'MatchGame' );
			if (false !== $MatchGame->update ()) {
				$this->success ( '新增成功！', U ( 'index?matchid=' . I ( 'match_id' ) ) );
			} else {
				$error = $MatchGame->getError ();
				$this->error ( empty ( $error ) ? '未知错误！' : $error );
			}
		} else {
			$this->meta_title = '编辑小组赛';
			empty ( $id ) && $this->error ( '参数不能为空！' );
			
			$games = $this->getGames ();
			$match = D ( 'MatchGame' )->field ( true )->find ( $id );
			$teams = $this->getTeams ( $match ['match_id'] );
			
			$this->assign ( 'teams', $teams );
			$this->assign ( 'matchgame', $match );
			$this->assign ( 'games', $games );
			
			$this->display ( 'edit' );
		}
	}
	public function addVideo($matchgameid = null) {
		if (IS_POST) {
			$data ['video_id'] = I ( 'post.video_id' );
			$data ['match_id'] = I ( 'post.match_id' );
			$data ['match_game_id'] = I ( 'post.match_game_id' );
			$MatchGameVideo = D ( 'MatchGameVideo' );
			$MatchGameVideo->add ( $data );
			
			unset ( $data ['match_game_id'] );
			$matchmap['id']=$data['match_id'];
			$match=D('Match')->find(intval($data['match_id']));
			$data['series_id']=$match['series_id'];
			$MatchVideo = D ( 'MatchVideo' );
			$MatchVideo->add ( $data );
			unset($data['series_id']);
			
			$data ['team_id'] = I ( 'post.blue_team_id' );
			unset ( $data ['match_id'] );
			$BlueTeamVideo = D ( 'TeamVideo' );
			$BlueTeamVideo->add ( $data );
			
			$data ['team_id'] = I ( 'post.red_team_id' );
			$RedTeamVideo = D ( 'TeamVideo' );
			$RedTeamVideo->add ( $data );
			$this->success ( '新增成功！', U ( 'addVideo?matchgameid=' . $matchgameid ) );
		} else {
			$matchgame = D ( 'MatchGame' )->field ( true )->find ( $id );
			$this->assign ( 'matchgame', $matchgame );
			$this->display ();
		}
	}
	public function changeStatus($method = null) {
		$id = array_unique ( ( array ) I ( 'id', 0 ) );
		$id = is_array ( $id ) ? implode ( ',', $id ) : $id;
		if (empty ( $id )) {
			$this->error ( '请选择要操作的数据!' );
		}
		$map ['id'] = array (
				'in',
				$id 
		);
		switch (strtolower ( $method )) {
			case 'forbidmatchgame' :
				$this->forbid ( 'MatchGame', $map );
				break;
			case 'resumematchgame' :
				$this->resume ( 'MatchGame', $map );
				break;
			case 'deletematchgame' :
				$this->delete ( 'MatchGame', $map );
				break;
			default :
				$this->error ( '参数非法' );
		}
	}
}