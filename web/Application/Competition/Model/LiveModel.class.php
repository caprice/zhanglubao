<?php

namespace Competition\Model;

use Think\Model;

class LiveModel extends Model {
	
	/**
	 *
	 * @param array $ids
	 *        	视频UID数组
	 * @return array 指定视频的相关信息
	 */
	public function getLiveInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getLiveInfo ( $v );
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
	public function getLiveInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		//$live = S ( 'live_info_' . $id );
		if (! $live) {
			$map ['id'] = $id;
			$live = $this->_getLiveInfo ( $map );
		}
		return $live;
	}
	public function getLivesInfo($map, $limit = 20, $order = 'id desc') {
		$lives = $this->where ( $map )->field ( array (
				'id' 
		) )->order ( $order )->limit ( $limit )->select ();
		
		foreach ( $lives as $v ) {
			! $cacheList [$v ['id']] && $cacheList [$v ['id']] = $this->getLiveInfo ( $v ['id'] );
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
	private function _getLiveInfo($map, $field = "*") {
		$live = $this->where ( $map )->field ( $field )->find ();
		S ( 'live_info_' . $live ['id'], $live, 86400 );
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
			$keys = S ( 'live_info_' . $id );
			foreach ( $keys as $k ) {
				S ( $k, null );
			}
			S ( 'live_info_' . $id, null );
		}
		
		return true;
	}
}

?>