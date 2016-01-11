<?php

namespace Competition\Model;

use Think\Model;

class MatchGameMemberModel extends Model {
	public function getMembers($team_id, $match_game_id) {
		// $members = S ( 'match_game_member_team_' . $team_id );
		if (! $members) {
			$map ['team_id'] = $team_id;
			$map ['match_game_id'] = $match_game_id;
			$members = $this->where ( $map )->select ();
			S ( 'match_game_member_team_' . $team_id, $members );
		}
		
		return $members;
	}
}