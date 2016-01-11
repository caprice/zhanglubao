<?php

namespace Competition\Model;

use Think\Model;

class MatchVideoModel extends Model {
 
	
	public function getVideosInfo($map, $limit = 20, $order = 'id desc') {
		$videos = $this->where ( $map )->field ( array (
				'video_id' 
		) )->order ( $order )->limit ( $limit )->select ();
		
		foreach ( $videos as $v ) {
			! $cacheList [$v ['video_id']] && $cacheList [$v ['video_id']] = D ( 'Video' )->getVideoInfo ( $v ['video_id'] );
		}
		return $cacheList;
	}
	
	
	public function getLatestVideo($matchid) {
		$map ['match_id'] = $matchid;
		//$matchvideos = S ( 'm_l_v_', $matchid );
		if (! $matchvideos) {
			$matchvideo = $this->getVideosInfo ( $map, 6 );
			$matchvideo = isset ( $matchvideo ) ? $matchvideo : array ();
			$count = count ( $matchvideo ) - 6;
			if ($count < 0) {
				$morevideo = $this->getVideosInfo ( array (), $count );
			}
			$morevideo = isset ( $morevideo ) ? $morevideo : array ();
			$matchvideos=array_merge($matchvideo,$morevideo);
			S ( 'm_l_v_', $matchid, $matchvideos,3000);
		}
		return  $matchvideos;
	}
	
}