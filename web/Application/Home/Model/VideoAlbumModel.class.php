<?php
namespace Home\Model;
use Think\Model;

class VideoAlbumModel extends Model{

	protected $_validate = array(
	array('title', 'require', '标题不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('tags', 'require', '标题不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('game_id', 'require', '选择游戏', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('cover', 'require', '选择游戏', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('description', 'require', '描述不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
	);
	protected $_auto = array(
	array('status', 1, self::MODEL_INSERT),
	array('create_time', NOW_TIME, self::MODEL_INSERT),
	array('update_time', NOW_TIME, self::MODEL_BOTH),
	array('uid', 'get_uid', self::MODEL_INSERT, 'function', 1),
	);

/**
	 * 更新分类信息
	 * @return boolean 更新状态
	 * @author Rocks
	 */
	public function update(){
		$data = $this->create();
		if(!$data){ //数据对象创建错误
			return false;
		}

		/* 添加或更新数据 */
		if(empty($data['id'])){
			$res = $this->add();
		}else{
			$res = $this->save();
		}
		$this->cleanCache(array($data['id']));
		action_log('update_album', 'album', $data['id'] ? $data['id'] : $res, UID);
		return $res;
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
		$album = array_merge ( $album, D('Picture')->getPicture($album['cover']));
		S('album_info_' . $album['id'], $album, 86400 );
		return $album;
	}

 
}