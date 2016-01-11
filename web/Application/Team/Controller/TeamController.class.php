<?php

namespace Team\Controller;

class TeamController extends BaseController {
	public function index() {
		$this->display ();
	}
	
	
	public function view($id) {
		$team = D ( 'Team' )->getTeamInfo ( $id );
		
		$members = D ( 'TeamMember' )->getTeamMember ( $id );
		$videos = D ( 'TeamVideo' )->getTeamVideo ( $id );
		$map ['status'] = 1;
		$map ['forum_id'] = $team ['forum_id'];
		$posts = D ( 'ForumPost' )->getForumPostsInfo ( $map, 16 );
		
		$this->assign ( 'teamid', $id );
		$this->assign ( 'posts', $posts );
		$this->assign ( 'videos', $videos );
		$this->assign ( 'members', $members );
		$this->assign ( 'team', $team );
		$this->display ();
	}
	
	
	
	public function video($id) {
		$team = D ( 'Team' )->getTeamInfo ( $id );
		$map ['team_id'] = $id;
		$videos = $this->lists ( 'TeamVideo', 32, $map );
		foreach ( $videos as $video ) {
			$list [] = D ( 'Video' )->getVideoInfo ( $video ['video_id'] );
		}
		$this->assign ( '_list', $list );
		$this->assign ( 'team', $team );
		$this->assign ( 'teamid', $id );
		$this->display ();
	}
	public function album($id) {
		$map ['team_id'] = $id;
		$albums = $this->lists ( 'VideoAlbumTeam', 4, $map );
		foreach ( $albums as $album ) {
			$list [] = D ( 'VideoAlbum' )->getAlbumInfo ( $album ['album_id'] );
		}
		$this->assign ( '_list', $list );
		$team = D ( 'Team' )->getTeamInfo ( $id );
		$this->assign ( 'team', $team );
		$this->assign ( 'teamid', $id );
		$this->display ();
	}
	public function match($id) {
		
		 
		$where=' red_team='.$id.' or '.' blue_team='.$id;
		
		$matches = $this->lists('MatchGame',30,$where);
		$team = D ( 'Team' )->getTeamInfo ( $id );
		$this->assign('matches',$matches);
		$this->assign ( 'team', $team );
		$this->assign ( 'teamid', $id );
		$this->display ();
	}
}