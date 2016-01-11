<?php

namespace User\Model;

use Think\Model;

class UserGroupModel extends Model{
	
	
	protected $_validate = array(
			array('group_name','require','国家名称必须填写'),
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
	
	public function addGroup($data) {
		$data = $this->create ( $data );
		if ($data) {
			$id = $this->add ( $data );
			$data['id']=$id;
			return $id ? $id : 0;
		} else {
			return false;
		}
	}
	
	
	public function editGroup($data) {
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