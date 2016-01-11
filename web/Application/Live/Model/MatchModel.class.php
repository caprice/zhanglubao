<?php
namespace Live\Model;
use Think\Model;

class MatchModel extends Model{


	
	public function  getMatchGameById($id)
	{
		$map['match_id']=$id;
		$matchs=D('MatchGame')->where($map)->field(true)->order('round asc')->select();
		$result = array();
		foreach($matchs as $key=>$value)
		{
			 
			$result[$value['round']][] = $value;
		}
		
		return $result;
	}

	/**
	 * 获取指定战队的相关信息
	 * @return array 指定战队的相关信息
	 */
	public function getMatchInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// $match = S('match_info_' . $id );
		if (! $match) {
			$map ['id'] = $id;
			$match = $this->_getMatchInfo ( $map );
		}
		return $match;
	}


	public function  getMatchesInfo($map=array(),$limit=20,$order='id desc')
	{
		$matchs=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $matchs as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getMatchInfo( $v['id'] );
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
	private function _getMatchInfo($map, $field = "*") {
		$match=$this->where($map)->field($field)->find();

		if ($match['end_time']>0)
		{
			$match['days'] = round(($match['end_time'] - time())/3600/24);
		}

		S('match_info_' . $match['id'], $match, 86400 );
		return $match;
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
			static_cache ( 'match_info_' . $id, false );
			$keys =S('match_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('match_info_'.$id,null);
		}

		return true;
	}

}

