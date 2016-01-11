<?php

namespace Team\Model;

use Think\Model;

class TeamVideoModel extends Model {
	
	
	public function getVideoInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		//$video = S ( 'team_video_info_' . $id );
		if (! $video) {
			$map ['id'] = $id;
			$video = $this->_getVideoInfo ( $map );
		}
		return $video;
	}
	
	
	public function getTeamVideo($teamid,$limit=20) {
		$map ['team_id'] = $teamid;
		return $this->getVideosInfo ( $map ,$limit);
	}
	
	
	public function getVideosInfo($map, $limit = 20, $order = 'id asc') {
		$team_videos = $this->where ( $map )->field ( array (
				'id' 
		) )->order ( $order )->limit ( $limit )->select ();
		foreach ( $team_videos as $v ) {
			! $cacheList [$v ['id']] && $cacheList [$v ['id']] = $this->getVideoInfo ( $v ['id'] );
		}
		
		return $cacheList;
	}
	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定游戏的相关信息
	 */
	private function _getVideoInfo($map, $field = "*") {
		$team_video = $this->where ( $map )->field ( $field )->find ();
		$team_videoinfo = D ( 'Video' )->getVideoInfo ( $team_video ['video_id'] );
		$team_video = array_merge ( $team_video, $team_videoinfo );
		S ( 'team_video_info_' . $team_video ['id'], $team_video, 86400 );
		return $team_video;
	}
	
	/**
	 * 清除指定Video数据
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys = S ( 'team_video_info_' . $id );
			foreach ( $keys as $k ) {
				S ( $k, null );
			}
			S ( 'team_video_info_' . $id, null );
		}
		
		return true;
	}
}