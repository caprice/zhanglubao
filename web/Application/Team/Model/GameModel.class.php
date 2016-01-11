<?php
namespace Team\Model;
use Think\Model;


class GameModel extends Model{


	

	public function  getAllChildren()
	{
	
		//$games=S('game_children');
		if (!$games) {
			$map['pid']=1;
			$games=$this->getGamesInfo($map);
			S('game_children',$games,80000);
		}
		return  $games;
	}
	
	/**
	 * 根据UID批量获取多个游戏的相关信息
	 *
	 * @param array $ids
	 *        	游戏UID数组
	 * @return array 指定游戏的相关信息
	 */
	public function getGameInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getGameInfo( $v );
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
	public function getGameByName($name) {
		if (empty($name)) {
			return false;
		}
		$game = S('game_info_name_' . $name );
		if (! $game) {
			$map ['name'] = $name;
			$game = $this->_getGameInfo ( $map );
			S('game_info_name_' . $name,$game,6000);
		}
		return $game;
	}
	
	
	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param integer $uid
	 *        	游戏UID
	 * @return array 指定游戏的相关信息
	 */
	public function getGameInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		$game = S('game_info_' . $id );
		if (! $game) {
			$map ['id'] = $id;
			$game = $this->_getGameInfo ( $map );
		}
		return $game;
	}


	public function  getGamesInfo($map,$limit=20,$order='sort asc')
	{
		$games=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $games as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getGameInfo( $v['id'] );
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
	private function _getGameInfo($map, $field = "*") {
		$game=$this->where($map)->field($field)->find();
		if ($game['online_member']<500)
		{
			$game['online_member']=rand(500, 6000);
		}
		if ($game['online_member']>10000)
		{
			$game['online_member']=round($game['online_member']/10000, 2).'万';
		}
		S('game_info_' . $game['id'], $game, 86400 );
		return $game;
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
			$keys =S('game_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('game_info_'.$id,null);
		}

		return true;
	}


}