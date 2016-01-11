<?php

namespace Fight\Model;

use Think\Model;

class FightModel extends Model {
	
	
	

	
	/**
	 * 获取指定战队的相关信息
	 * @return array 指定战队的相关信息
	 */
	public function getFightInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// $fight = S('fight_info_' . $id );
		if (! $fight) {
			$map ['id'] = $id;
			$fight = $this->_getFightInfo ( $map );
		}
		return $fight;
	}
	
	
	public function  getFightsInfo($map=array(),$limit=20,$order='id desc')
	{
		$fights=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();
	
		foreach ( $fights as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getFightInfo( $v['id'] );
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
	private function _getFightInfo($map, $field = "*") {
		$fight=$this->where($map)->field($field)->find();
		
		$fight['host']=D('Member')->getMemberInfo($fight['host_uid']);
		if ($fight['guest_uid']>0) {
			$fight['guest']=D('Member')->getMemberInfo($fight['guest_uid']);;
		}
		S('fight_info_' . $fight['id'], $fight, 86400 );
		return $fight;
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
			static_cache ( 'fight_info_' . $id, false );
			$keys =S('fight_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('fight_info_'.$id,null);
		}
	
		return true;
	}
	
}