<?php

namespace Team\Model;

use Think\Model;

class ForumModel extends Model {
	
	public function getForumName($id) {
		$forum = $this->getForumInfo ( $id );
		return $forum ['title'];
	}
	
	
	public function getForumInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getForumInfo ( $v );
		}
		
		return $cacheList;
	}
	
 
	
	
	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param integer $uid
	 *        	游戏UID
	 * @return array 指定游戏的相关信息
	 */
	public function getForumByName($name) {
		if (empty ( $name )) {
			return false;
		}
		$forum = S ( 'forum_info_name_' . $name );
		if (! $forum) {
			$map ['name'] = $name;
			$forum = $this->_getForumInfo ( $map );
			S ( 'forum_info_name_' . $name, $forum, 6000 );
		}
		return $forum;
	}
	
	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param integer $uid
	 *        	游戏UID
	 * @return array 指定游戏的相关信息
	 */
	public function getForumInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		//$forum = S ( 'forum_info_' . $id );
		if (! $forum) {
			$map ['id'] = $id;
			$forum = $this->_getForumInfo ( $map );
		}
		return $forum;
	}
	public function getForumsInfo($map, $limit = 20, $order = 'id asc') {
		$forums = $this->where ( $map )->field ( array (
				'id' 
		) )->order ( $order )->limit ( $limit )->select ();
		
		foreach ( $forums as $v ) {
			! $cacheList [$v ['id']] && $cacheList [$v ['id']] = $this->getForumInfo ( $v ['id'] );
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
	private function _getForumInfo($map, $field = "*") {
		$forum = $this->where ( $map )->field ( $field )->find ();
		S ( 'forum_info_' . $forum ['id'], $forum, 86400 );
		return $forum;
	}
	
	/**
	 * 清除指定Forum数据
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys = S ( 'forum_info_' . $id );
			foreach ( $keys as $k ) {
				S ( $k, null );
			}
			S ( 'forum_info_' . $id, null );
		}
		
		return true;
	}
}

