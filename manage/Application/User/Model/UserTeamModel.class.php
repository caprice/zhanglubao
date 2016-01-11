<?php

namespace User\Model;

use Think\Model;
class UserTeamModel extends Model{
	
	protected $_validate = array(
			array('uid','require','国家名称必须填写'),
			array('team_id','require','国家名称必须填写'),
	);
	/**
	 * 自动完成
	 * @author rocks
	*/
	protected $_auto = array(
			array('status', 1, self::MODEL_INSERT),
			array('create_time', NOW_TIME, self::MODEL_INSERT),
			array('update_time', NOW_TIME, self::MODEL_BOTH),
	);
	
	public function addMember($data) {
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
	public function editMember($data) {
		$data = $this->create ( $data);
		if ($data) {
			$id = $this->save ( $data );
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
}

?>