<?php
namespace Admin\Model;
use Think\Model;

class MatchGameDetailModel extends Model{

	protected $_validate = array(
	array('match_game_id', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
	);

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
		$this->cleanCache(array($data['match_game_id']));
		action_log('update_match_game_detail', 'match_game_detail', $data['id'] ? $data['id'] : $res, UID);
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
			static_cache ( 'match_game_info_' . $id, false );
			$keys =S('match_game_info_'.$id);
			foreach ($keys as $k){
				S($k,null);
			}
			S('match_game_info_'.$id,null);
		}

		return true;
	}

}

