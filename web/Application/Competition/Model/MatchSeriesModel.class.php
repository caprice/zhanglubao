<?php
namespace Competition\Model;
use Think\Model;

class MatchSeriesModel extends Model{
	
	
	/**
	 * @param array $ids
	 * @return array 指定系列赛的相关信息
	 */
	public function getSeriesInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getSeriesInfo( $v );
		}

		return $cacheList;
	}


	/**
	 * 获取指定系列赛的相关信息
	 *
	 * @param integer $uid
	 *        	系列赛UID
	 * @return array 指定系列赛的相关信息
	 */
	public function getSeriesInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		//$series = S('series_info_' . $id );
		if (! $series) {
			$map ['id'] = $id;
			$series = $this->_getSeriesInfo ( $map );
		}
		return $series;
	}


	public function  getSeriessInfo($map,$limit=20,$order='id desc')
	{
		
		$seriess=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $seriess as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getSeriesInfo( $v['id'] );
		}

		return $cacheList;

	}
	/**
	 * 获取指定系列赛的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定系列赛的相关信息
	 */
	private function _getSeriesInfo($map, $field = "*") {
		$series=$this->where($map)->field($field)->find();
		$series['format_tags']=explode ( ',', $series['tags']);
		S('series_info_' . $series['id'], $series, 86400 );
		return $series;
	}


	/**
	 * 清除指定系列赛缓存
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys =S('series_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('series_info_'.$id,null);
		}

		return true;
	}
	
	
}

	