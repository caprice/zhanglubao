<?php

namespace Common\Model;

use Think\Model;
class VideoUserModel extends Model{
	
	
	public function getVideoInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		if (! $video) {
			$map ['id'] = $id;
			$video = $this->_getVideoInfo ( $map );
		}
	
		return $video;
	}
	
	
 
	public function getVideosInfo($map, $limit = 20, $order = 'video_id desc') {
		
		$videos = $this->where ( $map )->cache(true,600)->field ( array (
				'id','video_id'
		) )->order($order)->limit ( $limit )->select ();
		
		 
		foreach ( $videos as $key=> $v ) {
			 $cacheList [] = $this->getVideoInfo ( $v ['video_id'] );
		}
	
		return $cacheList;
	}
	
	
	
	private function _getVideoInfo($map, $field = "*") {
		$video = D ( 'VideoVideo' )->field ( 'id,picture_id,video_title' )->where ( $map )->find ();
		return $video;
	}
	
	
	
}

?>