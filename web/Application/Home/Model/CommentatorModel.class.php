<?php
namespace Home\Model;
use Think\Model;

class CommentatorModel extends Model{


	/**
	 * 获取指定战队的相关信息
	 * @return array 指定战队的相关信息
	 */
	public function getCommentatorInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// $commentator = S('commentator_info_' . $id );
		if (! $commentator) {
			$map ['id'] = $id;
			$commentator = $this->_getCommentatorInfo ( $map );
		}
		return $commentator;
	}


	public function  getCommentatorsInfo($map=array(),$limit=20,$order='id desc')
	{
		$commentators=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();

		foreach ( $commentators as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getCommentatorInfo( $v['id'] );
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
	private function _getCommentatorInfo($map, $field = "*") {
		$commentator=$this->where($map)->field($field)->find();
		 S('commentator_info_' . $commentator['id'], $commentator, 86400 );
		return $commentator;
	}


	/**
	 * 清除指定Commentator数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			$keys =S('commentator_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('commentator_info_'.$id,null);
		}

		return true;
	}





}

