<?php

namespace Team\Model;

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
	
 
	
}