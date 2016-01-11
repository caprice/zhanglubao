<?php

namespace Competition\Model;
use Think\Model;
class MatchGameLiveModel extends Model {
 
	
	
	public function getLivesInfo($map, $limit = 20, $order = 'id desc') {
		$videos = $this->where ( $map )->field ( array (
				'live_id'
		) )->order ( $order )->limit ( $limit )->select ();
	
		foreach ( $videos as $v ) {
			! $cacheList [$v ['live_id']] && $cacheList [$v ['live_id']] = D ( 'Live' )->getLiveInfo ( $v ['live_id'] );
		}
		return $cacheList;
	}
}

?>