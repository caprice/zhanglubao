<?php

namespace Live\Model;

use Think\Model;
class LiveRecommendModel  extends Model{
	

	/**
	 *
	 * @param array $ids
	 *        	视频UID数组
	 * @return array 指定视频的相关信息
	 */
	public function getRecommendInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getRecommendInfo ( $v );
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
	public function getRecommendInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		//$live = S ( 'live_recommend_' . $id );
		if (! $live) {
			$map ['id'] = $id;
			$live = $this->_getRecommendInfo ( $map );
		}
		return $live;
	}
	public function getRecommendsInfo($map, $limit = 20, $order = 'id desc') {
		$lives = $this->where ( $map )->field ( array (
				'id'
		) )->order ( $order )->limit ( $limit )->select ();
	
		foreach ( $lives as $v ) {
			! $cacheList [$v ['id']] && $cacheList [$v ['id']] = $this->getRecommendInfo ( $v ['id'] );
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
	private function _getRecommendInfo($map, $field = "*") {
		$live = $this->where ( $map )->field ( $field )->find ();
		$liveinfo=D('Live')->getLiveInfo($live['live_id']);
		$live['flash_url']=$liveinfo['flash_url'];
		S ( 'live_recommend_' . $live ['id'], $live, 86400 );
		return $live;
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
			$keys = S ( 'live_recommend_' . $id );
			foreach ( $keys as $k ) {
				S ( $k, null );
			}
			S ( 'live_recommend_' . $id, null );
		}
	
		return true;
	}
}

?>