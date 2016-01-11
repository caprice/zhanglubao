<?php
namespace Team\Model;
use Think\Model;

class MatchGameModel extends Model{


	/**
	 * 获取指定战队的相关信息
	 * @return array 指定战队的相关信息
	 */
	public function getMatchGameInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		 $matchGame = S('match_game_info_' . $id );
		if (! $matchGame) {
			$map ['id'] = $id;
			$matchGame = $this->_getMatchGameInfo ( $map );
		}
		return $matchGame;
	}


	public function  getMatchGamesInfo($map=array(),$limit=20,$order='id desc')
	{
		$matchGames=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $matchGames as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getMatchGameInfo( $v['id'] );
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
	private function _getMatchGameInfo($map, $field = "*") {
		$matchGame=$this->where($map)->field($field)->find();
		S('match_game_info_' . $matchGame['id'], $matchGame, 86400 );
		return $matchGame;
	}


	/**
	 * 清除指定MatchGame数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys =S('match_game_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('match_game_info_'.$id,null);
		}

		return true;
	}





}

