<?php

namespace Competition\Controller;

class SeriesController extends BaseController {
	public function index() {
		
		
		$list = $this->lists ( 'MatchSeries' );
		$this->assign ( '_list', $list );
		$this->display ();
	}
	public function view($id) {
		$series = D ( 'MatchSeries' )->getSeriesInfo ( $id );
		$matchmap ['series_id'] = $series ['id'];
		$matches = D ( 'Match' )->where ( $matchmap )->select ();
		$videos = D ( 'MatchVideo' )->getVideosInfo ( $matchmap, 9 );
		
		$matchgames = D ( 'MatchGame' )->getMatchGamesInfo ( $matchmap, 4 );
		$this->assign ( 'newmatches', $matchgames );
		$this->assign ( 'videos', $videos );
		$this->assign ( 'matches', $matches );
		$this->assign ( 'series', $series );
		$this->display ();
	}
}