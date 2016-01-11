<?php
namespace Team\Model;
use Think\Model;

class VideoAlbumModel extends Model{

	 
	
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
			static_cache ( 'album_info_' . $id, false );
			$keys =S('album_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('album_info_'.$id,null);
		}

		return true;
	}
	
	
	
/**
	 * 根据UID批量获取多个视频的相关信息
	 *
	 * @param array $ids
	 *        	视频UID数组
	 * @return array 指定视频的相关信息
	 */
	public function getAlbumInfoByids($ids) {
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $v ) {
			! $cacheList [$v] && $cacheList [$v] = $this->getAlbumInfo( $v );
		}

		return $cacheList;
	}


	/**
	 * 获取指定视频的相关信息
	 *
	 * @param integer $uid
	 *        	视频UID
	 * @return array 指定视频的相关信息
	 */
	public function getAlbumInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		$album = S('album_info_' . $id );
		if (! $album) {
			$map ['id'] = $id;
			$album = $this->_getAlbumInfo ( $map );
		}
		return $album;
	}


	public function  getAlbumsInfo($map,$limit=20,$order='id desc')
	{
		$albums=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $albums as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getAlbumInfo( $v['id'] );
		}

		return $cacheList;

	}
	/**
	 * 获取指定视频的相关信息
	 *
	 * @param array $map
	 *        	查询条件
	 * @return array 指定视频的相关信息
	 */
	private function _getAlbumInfo($map, $field = "*") {
		$album=$this->where($map)->field($field)->find();
		S('album_info_' . $album['id'], $album, 86400 );
		return $album;
	}

 
}