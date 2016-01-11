<?php
namespace Admin\Model;
use Think\Model;

class MatchGameModel extends Model{

	protected $_validate = array(
	array('title', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('game_id', 'require', '标签不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('tags', 'require', '标签不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	);


	protected $_auto = array(
	array('status', 1, self::MODEL_INSERT),
		array('start_time', 'getStartTime', self::MODEL_BOTH,'callback'),
	);


	/**
	 * 更新分类信息
	 * @return boolean 更新状态
	 */
	public function update(){
		$data = $this->create();
		if(!$data){
			return false;
		}
		if(empty($data['id'])){
			$match=D('Match')->find($data['match_id']);
			$data['series_id']=$match['series_id'];
			$res = $this->add();
			
			
		}else{
			$res = $this->save();

		}
		$this->cleanCache(array($data['id']));
		action_log('update_match', 'match', $data['id'] ? $data['id'] : $res, UID);
		return $res;
	}

 
	public function  getStartTime()
	{
		$start_time    =   I('post.start_time');
		return $start_time?strtotime($start_time):NOW_TIME;
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
			static_cache ( 'team_info_' . $id, false );
			$keys =S('team_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('team_info_'.$id,null);
		}

		return true;
	}

}

