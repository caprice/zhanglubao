<?php
namespace Home\Model;
use Think\Model;

class MatchModel extends Model{

	  
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

