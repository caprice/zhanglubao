<?php
namespace Home\Model;
use Think\Model;

class AdModel extends Model{


	/**
	 * 获取指定战队的相关信息
	 * @return array 指定战队的相关信息
	 */
	public function getAdInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
	  $ad = S('ad_info_' . $id );
		if (! $ad) {
			$map ['id'] = $id;
			$ad = $this->_getAdInfo ( $map );
		}
		return $ad;
	}


	public function  getAdsInfo($map=array(),$limit=20,$order='id desc')
	{
		$ads=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $ads as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getAdInfo( $v['id'] );
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
	private function _getAdInfo($map, $field = "*") {
		$ad=$this->where($map)->field($field)->find();
		 S('ad_info_' . $ad['id'], $ad, 86400 );
		return $ad;
	}


	/**
	 * 清除指定Ad数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys =S('ad_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('ad_info_'.$id,null);
		}

		return true;
	}





}

