<?php
namespace Competition\Controller;
use Think\Controller;
class IndexController extends BaseController {

	public  function  index()
	{

		//$matches = S('c_i_match_list');
		if (empty($matches)) {
			$map['status']=1;

			$matches = D('Match')->getMatchesInfo($map,9,'match_status asc');
			S('c_i_match_list', $matches, 3000);
		}

		$this->assign('matches', $matches);

		//$guesses = S('c_i_guess_list');
		if (empty($guesses)) {
			$map['status']=1;
			$guesses = D('MatchGame')->getMatchGamesInfo($map,9);
			S('c_i_guess_list', $guesses, 3000);
		}
		$this->assign('guesses', $guesses);



		//$videos= S('c_i_video_list');
		if (empty($videos)) {
			$map=array();
			$videos = D('MatchVideo')->getVideosInfo($map,12);
			S('c_i_video_list', $videos, 3000);
		}
		$this->assign('videos', $videos);
		
		
		//$serieses= S('c_i_series_list');
		if (empty($serieses)) {
			$map=array();
			$serieses = D('MatchSeries')->getSeriessInfo($map,8);
			S('c_i_series_list', $serieses, 30000);
		}
		$this->assign('serieses', $serieses);
		
		
				//$members= S('c_i_series_list');
		if (empty($members)) {
			$map=array();
			$members = D('TeamMember')->getMembersInfo($map,12);
			S('c_i_member_list', $members, 30000);
		}
		$this->assign('members', $members);

		
					//$teams= S('c_i_team_list');
		if (empty($teams)) {
			$map['verify']=1;
			$teams = D('Team')->getTeamsInfo($map,12,' follows desc');
			S('c_i_team_list', $teams, 30000);
		}
		$this->assign('teams', $teams);
		
		

		$this->display();
	}
}