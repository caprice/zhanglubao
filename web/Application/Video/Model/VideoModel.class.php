<?php

namespace Video\Model;

use Think\Model;

class VideoModel extends Model {
	

	
	public function view($id)
	{
		$this->where(array('id',$id))->setInc('views');
	}
	public function  getAuthor($uid)
	{
		//$videos=S('video_user_'.$uid)
		if (!$videos) {
			$map['uid']=$uid;
			$videos = $this->getVideosInfo ( $map, 4 );
			S('video_user_'.$uid,$videos,86400);
		}
		return  $videos;
		
	}
	
	
	
	public function getNearVideos($id, $gameid) {
		//$videos = S ( 'video_near_' . $id .'_'.$gameid);
		if (! $videos) {
			$map ['id'] = array (
					'gt',
					$id
			);
			$map ['game_id'] = $gameid;
			$gtVideos = $this->getVideosInfo ( $map, 6 );
			$map ['id'] = array (
					'lt',
					$id
			);
			$ltVideos = $this->getVideosInfo ( $map, 6 );
				
			$videos = array_merge ( $gtVideos?$gtVideos:array(), $ltVideos?$ltVideos:array() );
			S ('video_near_' . $id .'_'.$gameid, $videos, 5000 );
		}
		return $videos;
	}
	
	
	
	
	/**
	 * 根据UID批量获取多个视频的相关信息
	 *
	 * @param array $ids
	 *        	视频UID数组
	 * @return array 指定视频的相关信息
	 */
	public function getVideoInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getVideoInfo ( $v );
		}
		
		return $cacheList;
	}
	
	/**
	 * 获取指定视频的相关信息
	 *
	 * @param integer $uid
	 *        	视频UID
	 * @return array 指定视频的相关信息
	 */
	public function getVideoInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		//$video = S ( 'video_info_' . $id );
		if (! $video) {
			$map ['id'] = $id;
			$video = $this->_getVideoInfo ( $map );
		}
		return $video;
	}
	
	
	
	public function getVideosInfo($map, $limit = 20, $order = 'id desc') {
		$videos = $this->where ( $map )->field ( array (
				'id' 
		) )->order ( $order )->limit ( $limit )->select ();
		
		
		foreach ( $videos as $v ) {
			! $cacheList [$v ['id']] && $cacheList [$v ['id']] = $this->getVideoInfo ( $v ['id'] );
		}
		return $cacheList;
	}
	
 
	/**
	 * 获取指定视频的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定视频的相关信息
	 */
	private function _getVideoInfo($map, $field = "*") {
		$video = $this->where ( $map )->field ( $field )->find ();
		
		$video ['format_tags'] = explode ( ',', $video ['tags'] );
		S ( 'video_info_' . $video ['id'], $video, 86400 );
		return $video;
	}
	
	/**
	 * 清除指定视频缓存
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys = S ( 'video_info_' . $id );
			foreach ( $keys as $k ) {
				S ( $k, null );
			}
			S ( 'video_info_' . $id, null );
		}
		
		return true;
	}
}

