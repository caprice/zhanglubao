<?php

namespace Team\Model;

use Think\Model;

class TeamModel extends Model {
	
	
	public function getTeamByForum($id) {
		
		
		$map ['forum_id'] = $id;
		return $this->_getTeamInfo ( $map );
	}
	public function getTeamInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getTeamInfo ( $v );
		}
		
		return $cacheList;
	}
	public function getTeamByName($name) {
		if (empty ( $name )) {
			return false;
		}
		$team = S ( 'team_info_name_' . $name );
		if (! $team) {
			$map ['name'] = $name;
			$team = $this->_getTeamInfo ( $map );
			S ( 'team_info_name_' . $name, $team, 6000 );
		}
		return $team;
	}
	public function getTeamInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		$team = S ( 'team_info_' . $id );
		if (! $team) {
			$map ['id'] = $id;
			$team = $this->_getTeamInfo ( $map );
		}
		return $team;
	}
	public function getTeamsInfo($map, $limit = 20, $order = 'sort asc') {
		$teams = $this->where ( $map )->field ( array (
				'id' 
		) )->order ( $order )->limit ( $limit )->select ();
		
		foreach ( $teams as $v ) {
			! $cacheList [$v ['id']] && $cacheList [$v ['id']] = $this->getTeamInfo ( $v ['id'] );
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
	private function _getTeamInfo($map, $field = "*") {
		$team = $this->where ( $map )->field ( $field )->find ();
		S ( 'team_info_' . $team ['id'], $team, 86400 );
		return $team;
	}
	
	/**
	 * 清除指定Team数据
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys = S ( 'team_info_' . $id );
			foreach ( $keys as $k ) {
				S ( $k, null );
			}
			S ( 'team_info_' . $id, null );
		}
		
		return true;
	}
}