<?php
namespace Video\Model;
use Think\Model;

class MasterModel extends Model{


	/**
	 * 获取指定战队的相关信息
	 * @return array 指定战队的相关信息
	 */
	public function getMasterInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// $master = S('master_info_' . $id );
		if (! $master) {
			$map ['id'] = $id;
			$master = $this->_getMasterInfo ( $map );
		}
		return $master;
	}


	public function  getMastersInfo($map=array(),$limit=20,$order='id desc')
	{
		$masters=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $masters as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getMasterInfo( $v['id'] );
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
	private function _getMasterInfo($map, $field = "*") {
		$master=$this->where($map)->field($field)->find();
		 S('master_info_' . $master['id'], $master, 86400 );
		return $master;
	}


	/**
	 * 清除指定Master数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys =S('master_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('master_info_'.$id,null);
		}

		return true;
	}





}

