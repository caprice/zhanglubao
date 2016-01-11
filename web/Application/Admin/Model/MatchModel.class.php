<?php
namespace Admin\Model;
use Think\Model;

class MatchModel extends Model{

	protected $_validate = array(
	array('title', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('game_id', 'require', '标签不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('tags', 'require', '标签不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('description', 'require', '描述不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
	);


	protected $_auto = array(
	array('start_time', 'getStartTime', self::MODEL_BOTH,'callback'),
	array('end_time', 'getEndTime', self::MODEL_BOTH,'callback'),
	array('status', 1, self::MODEL_INSERT),
	array('create_time', NOW_TIME, self::MODEL_INSERT),
	array('update_time', NOW_TIME, self::MODEL_BOTH),
	array('uid', 'get_uid', self::MODEL_INSERT, 'function', 1),
	);

	public function  getStartTime()
	{
		$start_time    =   I('post.start_time');
		return $start_time?strtotime($start_time):NOW_TIME;
	}
	public  function  getEndTime()
	{
		$end_time    =   I('post.end_time');
		return $end_time?strtotime($end_time):NOW_TIME;
	}


	/**
	 * 更新分类信息
	 * @return boolean 更新状态
	 * @author Rocks
	 */
	public function update(){
		$data = $this->create();
		if(!$data){
			return false;
		}
		if(empty($data['id'])){
			$res = $this->add();
		}else{
			$res = $this->save();

		}
		$this->cleanCache(array($data['id']));
		action_log('update_match', 'match', $data['id'] ? $data['id'] : $res, UID);
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

