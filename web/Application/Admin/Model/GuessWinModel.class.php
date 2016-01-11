<?php
namespace Admin\Model;
use Think\Model;

/**
 * 分类模型
 */
class GuessWinModel extends Model{
	protected $_validate = array(
	array('title', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	array('game_id', 'require', '标签不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	);


	protected $_auto = array(
	array('start_time', NOW_TIME, self::MODEL_INSERT),
	array('status', 1, self::MODEL_INSERT),
	array('create_time', NOW_TIME, self::MODEL_INSERT),
	array('uid', 'get_uid', self::MODEL_INSERT, 'function', 1),
	);


	/**
	 * 更新分类信息
	 * @return boolean 更新状态
	 */
	public function addGuessWin($data){
		$data['end_time']=$this->getEndTime($data['end_time']);
		$data = $this->create($data);
		if(!$data){  
			return false;
		}
		if(empty($data['id'])){
			$res = $this->add();
		}else{
			$res = $this->save();
		}
		$this->cleanCache(array($data['id']));
		action_log('update_guess_win', 'guesswin', $data['id'] ? $data['id'] : $res, UID);
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
			static_cache ( 'guess_win_' . $id, false );
			$keys =S('guess_win_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('guess_win_'.$id,null);
		}

		return true;
	}
	

	public  function  getEndTime($end_time)
	{
		return $end_time?strtotime($end_time):NOW_TIME;
	}
}