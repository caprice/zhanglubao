<?php

namespace Fight\Model;

use Think\Model;

class FightJoinModel extends Model {
	
	
	public function getFightJoinId($id) {
		// $fightjoins = S('fightjoin_join_' . $id );
		if (! $fightjoins) {
			$map ['fight_id'] = $id;
			$fightjoins = $this->getFightJoinsInfo($map,12);
			S ( 'fightjoin_join_' . $id, $fightjoins, 3000 );
		}
		
		return $fightjoins;
	}
	
	
	 
	public function getFightJoinInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// $fightjoin = S('fightjoin_info_' . $id );
		if (! $fightjoin) {
			$map ['id'] = $id;
			$fightjoin = $this->_getFightJoinInfo ( $map );
		}
		return $fightjoin;
	}
	
	
	public function  getFightJoinsInfo($map=array(),$limit=20,$order='id desc')
	{
		$fightjoins=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();
	
		foreach ( $fightjoins as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getFightJoinInfo( $v['id'] );
		}
	
		return $cacheList;
	
	}
	/**
	 * 获取指定战队的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定战队的相关信息
	 */
	private function _getFightJoinInfo($map, $field = "*") {
		$fightjoin=$this->where($map)->field($field)->find();
	 
		$fightjoin['user']=D('Member')->getMemberInfo($fightjoin['uid']);
		
		S('fightjoin_info_' . $fightjoin['id'], $fightjoin, 86400 );
		return $fightjoin;
	}
	
	
	
	/**
	 * 清除指定Game数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			static_cache ( 'fightjoin_info_' . $id, false );
			$keys =S('fightjoin_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('fightjoin_info_'.$id,null);
		}
	
		return true;
	}
	
}