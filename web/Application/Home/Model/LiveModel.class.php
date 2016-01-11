<?php
namespace Home\Model;
use Think\Model;

class LiveModel extends Model{

	protected $_validate = array(
	array('title', 'require', '标题不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('tags', 'require', '标题不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('game_id', 'require', '选择游戏', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('cover', 'require', '上传封面', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('description', 'require', '描述不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
	);
	protected $_auto = array(
	array('status', 1, self::MODEL_INSERT),
	array('create_time', NOW_TIME, self::MODEL_INSERT),
	array('update_time', NOW_TIME, self::MODEL_BOTH),
	);
	
	/**
	 * 更新分类信息
	 * @return boolean 更新状态
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
		action_log('update_live', 'live', $data['id'] ? $data['id'] : $res, UID);
		return $res;
	}
	
	

	/**
	 * 获取指定游戏的相关信息
	 *
	 * @param integer $uid
	 *        	游戏UID
	 * @return array 指定游戏的相关信息
	 */
	public function getLiveInfo($id) {
		$id = intval ( $id );
		if ($id <= 0) {
			return false;
		}
		// 查询缓存数据
		 $live = S('live_info_' . $id );
		if (! $live) {
			$map ['id'] = $id;
			$live = $this->_getLiveInfo ( $map );
		}
		return $live;
	}


	public function  getLivesInfo($map,$limit=20,$order='id desc')
	{
		
		
		$lives=$this->where($map)->field(array('id'))->order($order)->limit($limit)->select();
		foreach ( $lives as $v ) {
			! $cacheList [$v['id']] && $cacheList [$v['id']] = $this->getLiveInfo( $v['id'] );
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
	private function _getLiveInfo($map, $field = "*") {
		$live=$this->where($map)->field($field)->find();
		S('live_info_' . $live['id'], $live, 86400 );
		return $live;
	}

 

	/**
	 * 清除指定直播数据
	 *
	 */
	public function cleanCache($ids) {
		if (empty ( $ids )) {
			return false;
		}
		! is_array ( $ids ) && $ids = explode ( ',', $ids );
		foreach ( $ids as $id ) {
			static_cache ( 'live_info_' . $id, false );
			$keys =S('live_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('live_info_'.$id,null);
		}

		return true;
	}
	
}